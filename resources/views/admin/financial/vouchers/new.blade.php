@extends('admin.layouts.app')

@push('styles_top')
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/main.vouchers') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form action="{{ getAdminPanelUrl() }}/financial/vouchers/{{ !empty($voucher) ? $voucher->id.'/update' : 'store' }}" method="Post">
                            {{ csrf_field() }}

                            <!-- Code Case (Uppercase, Lowercase, Numbers, Symbols) -->
                            <div class="form-group mb-3">
                                <label>{{ trans('admin/main.code_case') }}</label><br>
                                <input type="checkbox" name="code_case[]" value="uppercase" id="code-case-uppercase" {{ in_array('uppercase', old('code_case', !empty($voucher) ? explode(',', $voucher->code_case) : [])) ? 'checked' : '' }}>
                                <label for="code-case-uppercase">{{ trans('admin/main.uppercase') }}</label>
                                <input type="checkbox" name="code_case[]" value="lowercase" id="code-case-lowercase" class="ml-2" {{ in_array('lowercase', old('code_case', !empty($voucher) ? explode(',', $voucher->code_case) : [])) ? 'checked' : '' }}>
                                <label for="code-case-lowercase">{{ trans('admin/main.lowercase') }}</label>
                                <input type="checkbox" name="code_case[]" value="numbers" id="code-case-numbers" class="ml-2" {{ in_array('numbers', old('code_case', !empty($voucher) ? explode(',', $voucher->code_case) : [])) ? 'checked' : '' }}>
                                <label for="code-case-numbers">{{ trans('admin/main.numbers') }}</label>
                                <input type="checkbox" name="code_case[]" value="symbols" id="code-case-symbols" class="ml-2" {{ in_array('symbols', old('code_case', !empty($voucher) ? explode(',', $voucher->code_case) : [])) ? 'checked' : '' }}>
                                <label for="code-case-symbols">{{ trans('admin/main.symbols') }}</label>
                                @error('code_case')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ trans('admin/main.code_length') }}</label>
                                <input type="number" name="code_length" class="form-control @error('code_length') is-invalid @enderror"
                                       value="{{ old('code_length', !empty($voucher) ? $voucher->code_length : 8) }}" min="1" id="code-length"/>
                                @error('code_length')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ trans('admin/main.amount') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            {{ $currency }}
                                        </div>
                                    </div>
                                    <input type="number" name="amount"
                                           class="form-control text-center @error('amount') is-invalid @enderror"
                                           value="{{ (!empty($voucher) and !empty($voucher->amount)) ? convertPriceToUserCurrency($voucher->amount) : old('amount') }}"/>
                                    @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bulk creation option -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.bulk_creation') }}</label>
                                <input type="number" name="bulk_quantity" class="form-control @error('bulk_quantity') is-invalid @enderror"
                                       value="{{ old('bulk_quantity', 1) }}" min="1" id="bulk-quantity"/>
                                <small id="bulk-quantity-notice" class="form-text text-muted">{{ trans('admin/main.bulk_creation_hint') }}</small>
                                @error('bulk_quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Batch Name -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.batch_name') }}</label>
                                <input type="text" name="batch_name" class="form-control @error('batch_name') is-invalid @enderror"
                                       value="{{ old('batch_name', !empty($voucher) ? $voucher->batch_name : '') }}"/>
                                @error('batch_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts_bottom')
<script src="/assets/default/js/admin/voucher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const codeLengthInput = document.getElementById('code-length');
        const amountInput = document.querySelector('input[name="amount"]');
        const bulkQuantityInput = document.getElementById('bulk-quantity');
        const batchNameInput = document.querySelector('input[name="batch_name"]');
        const form = document.querySelector('form');

        // Utility function to show an error message
        function showError(element, message) {
            element.classList.add('is-invalid');
            let errorDiv = element.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                element.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
        }

        // Utility function to clear error message
        function clearError(element) {
            element.classList.remove('is-invalid');
            const errorDiv = element.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.textContent = '';
            }
        }

        // Validate code length
        codeLengthInput.addEventListener('input', function () {
            const value = parseInt(codeLengthInput.value);
            if (value < 1) {
                showError(codeLengthInput, "{{ trans('admin/main.code_length_error') }}");
            } else {
                clearError(codeLengthInput);
            }
        });

        // Validate amount
        amountInput.addEventListener('input', function () {
            const value = parseFloat(amountInput.value);
            if (isNaN(value) || value <= 0) {
                showError(amountInput, "{{ trans('admin/main.amount_error') }}");
            } else {
                clearError(amountInput);
            }
        });

        // Validate bulk quantity
        bulkQuantityInput.addEventListener('input', function () {
            const value = parseInt(bulkQuantityInput.value);
            if (value < 1) {
                showError(bulkQuantityInput, "{{ trans('admin/main.bulk_quantity_error') }}");
            } else {
                clearError(bulkQuantityInput);
            }
        });

        // Validate batch name
        batchNameInput.addEventListener('input', function () {
            if (batchNameInput.value.trim() === '') {
                showError(batchNameInput, "{{ trans('admin/main.batch_name_error') }}");
            } else {
                clearError(batchNameInput);
            }
        });

        // Function to validate selected case options
        function validateCodeCases() {
            const selectedCases = getSelectedCases();
            if (selectedCases.length === 0) {
                showError(document.querySelector('input[name="code_case[]"]'), "{{ trans('admin/main.code_case_error') }}");
                return false;
            } else {
                clearError(document.querySelector('input[name="code_case[]"]'));
                return true;
            }
        }

        // Function to validate all fields
        function validateForm(event) {
            let valid = true;

            // Validate each field with its individual validation
            if (codeLengthInput.value < 1) {
                showError(codeLengthInput, "{{ trans('admin/main.code_length_error') }}");
                valid = false;
            }
            if (!amountInput.value || parseFloat(amountInput.value) <= 0) {
                showError(amountInput, "{{ trans('admin/main.amount_error') }}");
                valid = false;
            }
            if (bulkQuantityInput.value < 1) {
                showError(bulkQuantityInput, "{{ trans('admin/main.bulk_quantity_error') }}");
                valid = false;
            }
            if (batchNameInput.value.trim() === '') {
                showError(batchNameInput, "{{ trans('admin/main.batch_name_error') }}");
                valid = false;
            }
            if (!validateCodeCases()) {
                valid = false;
            }

            // Prevent form submission if validation fails
            if (!valid) {
                event.preventDefault();
            }
        }

        // Listen for form submission
        form.addEventListener('submit', validateForm);

        // Function to generate unique code based on selected case
        function generateCode() {
            const codeCase = getSelectedCases();
            const codeLength = parseInt(codeLengthInput.value) || 8; // Default to 8 if no value

            const generatedCode = generateUniqueCode(codeLength, codeCase);

            document.getElementById('voucher-code').value = generatedCode;
            document.getElementById('code-notice').innerText = 'Generated code: ' + generatedCode;
        }

        // Function to generate unique code with selected case options
        function generateUniqueCode(codeLength, codeCase) {
            const charsUppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const charsLowercase = 'abcdefghijklmnopqrstuvwxyz';
            const charsNumbers = '0123456789';
            const charsSymbols = '!@#$%^&*()_-+=<>?';

            let chars = '';

            // Include characters based on selected case
            if (codeCase.includes('uppercase')) {
                chars += charsUppercase;
            }
            if (codeCase.includes('lowercase')) {
                chars += charsLowercase;
            }
            if (codeCase.includes('numbers')) {
                chars += charsNumbers;
            }
            if (codeCase.includes('symbols')) {
                chars += charsSymbols;
            }

            let code = '';
            for (let i = 0; i < codeLength; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            return code;
        }

        // Helper function to retrieve selected case types
        function getSelectedCases() {
            const cases = [];
            document.querySelectorAll('input[name="code_case[]"]:checked').forEach((checkbox) => {
                cases.push(checkbox.value);
            });
            return cases;
        }

        // Watch for changes in code length and case, and regenerate the code when needed
        document.querySelectorAll('input[name="code_case[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', generateCode);
        });
        codeLengthInput.addEventListener('input', generateCode);
    });
</script>
@endpush

