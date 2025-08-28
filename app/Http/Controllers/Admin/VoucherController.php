<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VoucherGroupsExport;
use App\Exports\VouchersExport;
use Barryvdh\DomPDF\Facade\Pdf;




class VoucherController extends Controller
{
public function exportVoucherAsPdf($voucherId)
{
    // Retrieve the voucher by its ID
    $voucher = Voucher::with('user')->findOrFail($voucherId);

    // Generate the PDF
    $pdf = PDF::loadView('admin.financial.vouchers.pdf', compact('voucher'));

    // Return the PDF as a download
    return $pdf->download('voucher_' . $voucher->code . '.pdf');
}

public function index()
{
    \Log::info('Fetching the list of voucher groups');

    // Fetch only the batch_name, created_at (from any voucher in the group), and count of vouchers in each group
    $voucherGroups = Voucher::select('batch_name', \DB::raw('MIN(created_at) as created_at'), \DB::raw('COUNT(*) as vouchers_count'))
        ->groupBy('batch_name')
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Adjust pagination as needed

    \Log::info('Voucher groups fetched', ['count' => $voucherGroups]);

    $data = [
        'pageTitle' => trans('admin/main.vouchers_title'),
        'voucherGroups' => $voucherGroups, // Pass the groups to the view
    ];
\Log::info('Voucher groups fetched', ['count' => $data]);
    return view('admin.financial.vouchers.lists', $data);
}

public function exportVouchersInGroupAsPdf($batchName)
{
    // Retrieve all vouchers in the specified group
    $vouchers = Voucher::where('batch_name', $batchName)
        ->get();

    if ($vouchers->isEmpty()) {
        \Log::warning('No vouchers found in group', ['batch_name' => $batchName]);
        return response()->json(['message' => 'No vouchers found in this group.'], 404);
    }

    // Generate the PDF
    $pdf = \PDF::loadView('admin.financial.vouchers.group_pdf', compact('vouchers'));

    // Return the PDF as a download
    return $pdf->download('vouchers_in_group_' . $batchName . '.pdf');
}


    // Show form to create a new voucher
    public function create()
    {
        \Log::info('Displaying the form to create a new voucher');

        //$this->authorize('admin_vouchers_create');

        $data = [
            'pageTitle' => trans('admin/main.new_voucher_title'),
        ];

        return view('admin.financial.vouchers.new', $data);
    }

    public function validateVoucher(Request $request)
    {
        \Log::info('Starting voucher validation');

        // Check if the 'code' input exists
        $voucherCode = $request->get('voucher');
        if (!$voucherCode) {
            \Log::error('Voucher code not provided in request');
            return response()->json([
                'valid' => false,
                'message' => 'Voucher code is required.'
            ], 400);
        }

        \Log::info('Voucher code received', ['code' => $voucherCode]);

        // Retrieve the voucher based on the input code
        $voucher = Voucher::where('code', $voucherCode)->first();

        // Check if voucher is found in the database
        if ($voucher) {
            \Log::info('Voucher found in database', ['voucher_id' => $voucher->id, 'is_used' => $voucher->is_used]);

            // Check if the voucher is already used
            if (!$voucher->is_used) {
                \Log::info('Voucher is valid and not used', ['voucher_code' => $voucherCode]);

                return response()->json([
                    'valid' => true,
                    'message' => 'Voucher is valid.',
                    'amount' => $voucher->amount
                ]);
            } else {
                \Log::warning('Voucher is already used', ['voucher_code' => $voucherCode]);
                return response()->json([
                    'valid' => false,
                    'message' => 'Voucher has already been used.'
                ], 400);
            }
        } else {
            \Log::error('Voucher not found in database', ['voucher_code' => $voucherCode]);
            return response()->json([
                'valid' => false,
                'message' => 'Invalid voucher code.'
            ], 400);
        }
    }
public function viewGroup($batchName)
{
    \Log::info('Displaying the list of vouchers for group', ['batch_name' => $batchName]);

    // Base query for retrieving vouchers by batch name
    $vouchersQuery = Voucher::where('batch_name', $batchName)->with('user');

    // Apply filters
    if (request()->has('search') && !empty(request()->get('search'))) {
        $vouchersQuery->where('code', 'like', '%' . request()->get('search') . '%');
    }
    if (request()->has('from') && !empty(request()->get('from'))) {
        $vouchersQuery->whereDate('expired_at', '>=', request()->get('from'));
    }
    if (request()->has('to') && !empty(request()->get('to'))) {
        $vouchersQuery->whereDate('expired_at', '<=', request()->get('to'));
    }
    if (request()->has('status') && !empty(request()->get('status'))) {
        $status = request()->get('status') === 'active' ? false : true;
        $vouchersQuery->where('is_used', $status);
    }

    // Apply sorting
    if (request()->has('sort') && !empty(request()->get('sort'))) {
        switch (request()->get('sort')) {
            case 'amount_asc':
                $vouchersQuery->orderBy('amount', 'asc');
                break;
            case 'amount_desc':
                $vouchersQuery->orderBy('amount', 'desc');
                break;
            case 'created_at_asc':
                $vouchersQuery->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
                $vouchersQuery->orderBy('created_at', 'desc');
                break;
            default:
                $vouchersQuery->orderBy('created_at', 'desc');
                break;
        }
    } else {
        $vouchersQuery->orderBy('created_at', 'desc');
    }

    // Paginate results
    $vouchers = $vouchersQuery->paginate(10);

    \Log::info('Vouchers fetched for batch group', ['batch_name' => $batchName, 'count' => $vouchers]);

    // Pass data to the view
    $data = [
        'pageTitle' => trans('admin/main.vouchers_in_group_title', ['batch_name' => $batchName]),
        'vouchers' => $vouchers,
        'batchName' => $batchName,
    ];

    return view('admin.financial.vouchers.vouchers', $data);
}
public function exportVoucherGroups(Request $request)
{

    // Retrieve unique voucher groups with batch_name and other aggregate data if needed
    $groups = Voucher::select('batch_name')
        ->distinct()
        ->orderBy('batch_name')
        ->get();

    // Create a new export instance with the group data
    $export = new VoucherGroupsExport($groups);

    // Download the export as an Excel file
    return Excel::download($export, 'voucher_groups.xlsx');
}

public function exportVouchers(Request $request, $batchName)
{
    // Define base query for retrieving vouchers
    // Define base query for retrieving vouchers
    $vouchersQuery = Voucher::where('batch_name', $batchName)
        ->select('batch_name', 'code', 'amount', 'created_at', 'user_id', 'is_used')
        ->with('user')
        ->orderBy('created_at', 'desc');
    // Apply filters if they exist in the request
    if ($request->has('search') && !empty($request->get('search'))) {
        $vouchersQuery->where('code', 'like', '%' . $request->get('search') . '%');
    }
    if ($request->has('from') && !empty($request->get('from'))) {
        $vouchersQuery->whereDate('created_at', '>=', $request->get('from'));
    }
    if ($request->has('to') && !empty($request->get('to'))) {
        $vouchersQuery->whereDate('created_at', '<=', $request->get('to'));
    }
    if ($request->has('status') && !empty($request->get('status'))) {
        $status = $request->get('status') === 'active' ? false : true;
        $vouchersQuery->where('is_used', $status);
    }

    // Fetch the filtered vouchers
    $vouchers = $vouchersQuery->get();

    // Create a new export instance and pass the vouchers
    $export = new VouchersExport($vouchers);

    // Download the export as an Excel file
    return Excel::download($export, 'vouchers.xlsx');
}

public function store(Request $request)
{
    \Log::info('Storing a newly created voucher');

    // Set the bulk quantity (default to 1 if not provided)
    $bulkQuantity = $request->input('bulk_quantity', 1);
    $codeCase = $request->input('code_case'); // Now we only use code_case
    $codeLength = $request->input('code_length');
    $amount = $request->input('amount');  // Get the amount directly from request
    $creator = auth()->user()->id; // Assuming you're using Laravel's authentication
    $batchName = $request->input('batch_name'); // Set batch name from the request

    \Log::info('Voucher data validated', [
        'amount' => $amount,
        'bulk_quantity' => $bulkQuantity,
        'code_case' => $codeCase,
        'code_length' => $codeLength,
        'creator' => $creator,
        'batch_name' => $batchName,
    ]);

    // Generate vouchers in bulk
    for ($i = 0; $i < $bulkQuantity; $i++) {
        $voucherCode = $this->generateVoucherCode($codeCase, $codeLength);

        // Ensure unique code generation
        while (Voucher::where('code', $voucherCode)->exists()) {
            $voucherCode = $this->generateVoucherCode($codeCase, $codeLength);
        }

        // Create the voucher record
        Voucher::create([
            'code' => $voucherCode,
            'amount' => $amount,
            'is_used' => false,  // Set to false on creation
            'creator' => $creator,  // Add creator ID
            'batch_name' => $batchName,  // Add batch name
            'created_at' => time(),
        ]);

        \Log::info('Voucher successfully created', ['code' => $voucherCode]);
    }

    return redirect(getAdminPanelUrl() . '/financial/vouchers')
        ->with('success', trans('admin/main.vouchers_created_success'));
}

// Method to generate voucher code based on input parameters
protected function generateVoucherCode(array $codeCase, int $codeLength): string
{
    $charsAlphanumeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charsNumeric = '0123456789';

    // Determine code character set based on selected cases
    $chars = $charsAlphanumeric; // Default to alphanumeric characters

    // Generate the voucher code
    $voucherCode = '';
    for ($i = 0; $i < $codeLength; $i++) {
        $voucherCode .= $chars[random_int(0, strlen($chars) - 1)];
    }

    // Adjust case based on user selection
    if (in_array('uppercase', $codeCase)) {
        $voucherCode = strtoupper($voucherCode);
    } elseif (in_array('lowercase', $codeCase)) {
        $voucherCode = strtolower($voucherCode);
    } elseif (in_array('mixed', $codeCase)) {
        $voucherCode = $this->mixCase($voucherCode);
    }

    return $voucherCode;
}

// Method to mix case for 'mixed' case option
protected function mixCase(string $code): string
{
    $result = '';
    foreach (str_split($code) as $char) {
        $result .= random_int(0, 1) ? strtoupper($char) : strtolower($char);
    }
    return $result;
}


    // Show form to edit an existing voucher
    public function edit($id)
    {
        \Log::info('Displaying the form to edit voucher', ['voucher_id' => $id]);

        //$this->authorize('admin_vouchers_edit');

        $voucher = Voucher::findOrFail($id);

        \Log::info('Voucher found for editing', ['voucher_id' => $voucher->id]);

        $data = [
            'pageTitle' => trans('admin/main.edit_voucher_title'),
            'voucher' => $voucher,
        ];

        return view('admin.financial.vouchers.new', $data);
    }
// Delete all vouchers in a specific group (batch_name)
public function deleteGroup($batchName)
{
    \Log::info('Deleting all vouchers for group', ['batch_name' => $batchName]);

    // Delete vouchers that belong to the specified batch group
    $deletedCount = Voucher::where('batch_name', $batchName)->delete();

    \Log::info('Vouchers deleted for batch group', ['batch_name' => $batchName, 'deleted_count' => $deletedCount]);

    // Redirect back with a success message
    return redirect()->back()->with('success', trans('admin/main.vouchers_deleted_success', ['batch_name' => $batchName, 'count' => $deletedCount]));
}


    // Update an existing voucher
    public function update(Request $request, $id)
    {
        \Log::info('Updating voucher', ['voucher_id' => $id]);

        //$this->authorize('admin_vouchers_edit');

        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:vouchers,code,' . $voucher->id,
            'amount' => 'required|numeric|min:0',
        ]);

        \Log::info('Voucher data validated for update', [
            'voucher_id' => $voucher->id,
            'code' => $request->input('code'),
            'amount' => $request->input('amount')
        ]);

        $voucher->update([
            'code' => $request->input('code'),
            'amount' => $request->input('amount'),
        ]);

        \Log::info('Voucher updated successfully', ['voucher_id' => $voucher->id]);

        return redirect()->route('admin.vouchers.index');
    }

    // Mark voucher as used when redeemed
    public function redeemVoucher(Request $request)
    {
        \Log::info('Redeeming voucher', ['voucher_code' => $request->input('code')]);

        $voucher = Voucher::where('code', $request->input('code'))->first();

        if ($voucher && !$voucher->is_used) {
            $voucher->update(['is_used' => true]); // Mark as used

            \Log::info('Voucher redeemed successfully', ['voucher_code' => $voucher->code]);

            return response()->json(['message' => 'Voucher redeemed successfully']);
        }

        \Log::error('Invalid or already used voucher', ['voucher_code' => $request->input('code')]);

        return response()->json(['message' => 'Invalid or already used voucher'], 400);
    }

    // Delete a voucher
    public function destroy($id)
    {
        \Log::info('Deleting voucher', ['voucher_id' => $id]);

        //$this->authorize('admin_vouchers_delete');

        Voucher::find($id)->delete();

        \Log::info('Voucher deleted successfully', ['voucher_id' => $id]);

        return redirect(getAdminPanelUrl() . '/financial/vouchers');
    }
}
