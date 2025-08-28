<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Translation\SubjectTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
	public function index()
    {
        removeContentLocale();

        $this->authorize('admin_categories_list');

        $subjects = Subject::orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/subjects.subjects_list_page_title'),
            'subjects' => $subjects
        ];

        return view('admin.subjects.lists', $data);
    }

      public function create()
    {
        $this->authorize('admin_categories_create');

        $data = [
            'pageTitle' => trans('admin/main.category_new_page_title'),
        ];

        return view('admin.subjects.create', $data);
    }


  public function store(Request $request)
    {
        $this->authorize('admin_categories_create');

        $this->validate($request, [
            'title' => 'required|min:3|max:128',
            'slug' => 'nullable|max:255|unique:subjects,slug',
        ]);

        $data = $request->all();

        $order = $data['order'] ?? Subject::count() + 1;

        $subject = Subject::create([
            'slug' => $data['slug'] ?? Subject::makeSlug($data['title']),
            'icon' => $data['icon'] ?? null,
            'order' => $order,
        ]);

        SubjectTranslation::updateOrCreate([
            'subject_id' => $subject->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
        ]);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/subject');
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $subject = Subject::findOrFail($id);

        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $subject->getTable(), $subject->id);

        $data = [
            'pageTitle' => trans('admin/pages/categories.edit_page_title'),
            'subject' => $subject,
        ];

        return view('admin.subjects.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $subject = Subject::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|max:255|unique:subjects,slug,' . $subject->id,
        ]);

        $data = $request->all();

        $subject->update([
            'icon' => $data['icon'] ?? null,
            'slug' => $data['slug'] ?? Subject::makeSlug($data['title']),
            'order' => $data['order'] ?? $subject->order,
        ]);

        SubjectTranslation::updateOrCreate([
            'subject_id' => $subject->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
        ]);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/subject');
    }
  
  
  public function destroy(Request $request, $id)
    {
        $this->authorize('admin_categories_delete');

        $subject = Subject::findOrFail($id);
        $subject->delete();

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.category_successfully_deleted'),
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/subject')->with(['toast' => $toastData]);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        $option = $request->get('option', null);

        $query = Subject::select('id')
            ->whereTranslationLike('title', "%$term%");

        $subjects = $query->get();

        return response()->json($subjects, 200);
    }
}
