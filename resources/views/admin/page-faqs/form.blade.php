    @include('admin.include.sidebar')
    <div class="wrapper">
       <div id="content">
          <div class="navbar-expand-lg navbar-light bg-light" style="padding: 15px;">

             <h4 style="margin-bottom: 15px;">{{ $faq->exists ? 'Edit FAQ' : 'Add FAQ' }}</h4>

             @if ($errors->any())
                <div class="alert alert-danger">
                   <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                      @endforeach
                   </ul>
                </div>
             @endif

             <form action="{{ $faq->exists ? route('admin.pagefaqs.update', $faq->id) : route('admin.pagefaqs.store') }}" method="POST">
                @csrf
                @if ($faq->exists)
                   @method('PATCH')
                @endif
                <div class="col-12">
                   <div class="row">
                      <div class="col-md-8 form-group">
                         <label for="page">Show on page</label>
                         <select class="form-control" id="page" name="page" required>
                            @foreach ($pages as $key => $label)
                               <option value="{{ $key }}" @selected(old('page', $faq->page) === $key)>{{ $label }}</option>
                            @endforeach
                         </select>
                      </div>
                      <div class="col-md-4 form-group">
                         <label for="sort_order">Order <small class="text-muted">(lower shows first)</small></label>
                         <input type="number" min="0" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $faq->sort_order) }}">
                      </div>
                      <div class="col-md-12 form-group mt-2">
                         <label for="question">Question</label>
                         <input type="text" class="form-control" id="question" name="question" maxlength="500" value="{{ old('question', $faq->question) }}" placeholder="Enter question" required>
                      </div>
                      <div class="col-md-12 form-group mt-2">
                         <label for="answer">Answer</label>
                         {{-- No "required" here: the admin turns textareas into a CKEditor rich-text box and hides
                              the original, and browsers block submitting a hidden required field. The server checks it. --}}
                         <textarea class="form-control" id="answer" name="answer" rows="6" placeholder="Enter answer">{{ old('answer', $faq->answer) }}</textarea>
                      </div>
                      <div class="col-md-12 mt-2">
                         <input type="submit" class="btn btn-success" value="Save">
                         <a href="{{ route('admin.pagefaqs.index', ['page_key' => $faq->page]) }}" class="btn btn-secondary">Back</a>
                      </div>
                   </div>
                </div>
             </form>
          </div>
       </div>
    </div>
