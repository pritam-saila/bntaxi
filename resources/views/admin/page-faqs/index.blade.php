    @include('admin.include.sidebar')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-danger">
                <i class="fas fa-align-left"></i>
            </button>
            @if(session()->has('success'))
            <div class="alert alert-success mb-0 alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <a class="btn btn-danger" href="{{ route('admin.pagefaqs.create', ['page_key' => $page]) }}">Add New FAQ</a>
        </div>
    </nav>

    <div class="wrapper">
        <div id="content" style="padding: 20px 0;">
            <div class="navbar-expand-lg navbar-light bg-light" style="padding: 15px;">

                <h4 style="margin-bottom: 6px;">Page FAQs</h4>
                <p class="text-muted" style="margin-bottom: 15px;">
                    Questions shown at the bottom of each page (and given to Google as FAQ data).
                    FAQs for individual routes are under <a href="{{ route('admin.routehandles.index') }}">Route handles</a>.
                </p>

                {{-- Page picker --}}
                <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px;">
                    @foreach ($pages as $key => $label)
                        <a href="{{ route('admin.pagefaqs.index', ['page_key' => $key]) }}"
                           class="btn {{ $key === $page ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                            {{ $label }} <span class="badge badge-light">{{ $counts[$key] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>

                <table class="table table-striped table-bordered dark" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Order</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td>{{ $item->sort_order }}</td>
                            <td>{{ $item->question }}</td>
                            <td>{{ \Illuminate\Support\Str::limit(strip_tags($item->answer), 90) }}</td>
                            <td class="action">
                                <a class="btn btn-info" href="{{ route('admin.pagefaqs.edit', $item->id) }}" aria-label="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.pagefaqs.destroy', $item->id) }}" method="POST" style="display: contents;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-warning" aria-label="Delete" onclick="return confirm('Do you really want to delete this FAQ?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No FAQs on this page yet. The FAQ section is hidden until you add one.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
