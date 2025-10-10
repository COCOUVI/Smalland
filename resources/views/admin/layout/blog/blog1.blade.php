@extends('admin.master')
@section('content')
    
<style>
    .editor-container {
  border: 1px solid #ccc;
  width: 100%;
  font-family: sans-serif;
}

.toolbar {
  background-color: #f9f9f9;
  padding: 5px;
  border-bottom: 1px solid #ccc;
}

.toolbar button {
  background: none;
  border: none;
  cursor: pointer;
  margin-right: 8px;
  font-size: 16px;
}

.editor {
  min-height: 150px;
  padding: 10px;
  outline: none;
}

</style>
    <!-- Main Content -->
      
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Write Your Post</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control">
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric">
                          <option>Tech</option>
                          <option>News</option>
                          <option>Political</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="editor-container">
                            <div class="toolbar">
                                <button onclick="format('bold')"><b>B</b></button>
                                <button onclick="format('italic')"><i>I</i></button>
                                <button onclick="format('underline')"><u>U</u></button>
                                <button onclick="format('strikeThrough')"><s>S</s></button>
                                <button onclick="format('insertUnorderedList')">•</button>
                                <button onclick="toggleAlign()">☰</button>
                            </div>
                            <div id="editor" contenteditable="true" class="editor"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                      <div class="col-sm-12 col-md-7">
                        <div id="image-preview" class="image-preview">
                          <label for="image-upload" id="image-label">Choose File</label>
                          <input type="file" name="image" id="image-upload" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tags</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control inputtags">
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric">
                          <option>Publish</option>
                          <option>Draft</option>
                          <option>Pending</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Create Post</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        
     
@endsection
<script>
  function format(command) {
    document.execCommand(command, false, null);
  }

  let alignedLeft = true;
  function toggleAlign() {
    const newAlign = alignedLeft ? 'justifyRight' : 'justifyLeft';
    format(newAlign);
    alignedLeft = !alignedLeft;
  }
</script>


