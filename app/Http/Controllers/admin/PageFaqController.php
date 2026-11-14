<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * FAQs for the homepage, About page and service pages.
 * (Route FAQs are managed under Route handles -> FAQ, see FaqController.)
 */
class PageFaqController extends Controller
{
    public function index(Request $request)
    {
        $pages = Faq::pageOptions();
        $page = array_key_exists($request->query('page_key'), $pages) ? $request->query('page_key') : array_key_first($pages);

        return view('admin.page-faqs.index', [
            'pages' => $pages,
            'page' => $page,
            'counts' => Faq::whereNotNull('page')->selectRaw('page, COUNT(*) as total')->groupBy('page')->pluck('total', 'page'),
            'data' => Faq::forPage($page)->get(),
        ]);
    }

    public function create(Request $request)
    {
        $pages = Faq::pageOptions();
        $page = array_key_exists($request->query('page_key'), $pages) ? $request->query('page_key') : array_key_first($pages);

        return view('admin.page-faqs.form', [
            'pages' => $pages,
            'faq' => new Faq(['page' => $page, 'sort_order' => (int) Faq::where('page', $page)->max('sort_order') + 1]),
        ]);
    }

    public function store(Request $request)
    {
        $faq = Faq::create($this->validated($request));

        return redirect()->route('admin.pagefaqs.index', ['page_key' => $faq->page])->with('success', 'FAQ created successfully');
    }

    public function edit(Faq $page_faq)
    {
        abort_if($page_faq->page === null, 404);

        return view('admin.page-faqs.form', ['pages' => Faq::pageOptions(), 'faq' => $page_faq]);
    }

    public function update(Request $request, Faq $page_faq)
    {
        abort_if($page_faq->page === null, 404);
        $page_faq->update($this->validated($request));

        return redirect()->route('admin.pagefaqs.index', ['page_key' => $page_faq->page])->with('success', 'FAQ updated successfully');
    }

    public function destroy(Faq $page_faq)
    {
        abort_if($page_faq->page === null, 404);
        $page = $page_faq->page;
        $page_faq->delete();

        return redirect()->route('admin.pagefaqs.index', ['page_key' => $page])->with('success', 'FAQ deleted successfully');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'page' => ['required', Rule::in(array_keys(Faq::pageOptions()))],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:10000'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
