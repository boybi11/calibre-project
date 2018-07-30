<div class="modal fade" id="assets-modal" tabindex="-1" role="dialog" aria-labelledby="assetsModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Select File</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row loader-asset">
            <div class="col-xs-12">
              <div class="loader">
                <div class="display-table">
                  <div class="display-cell">
                    <div class="spinner"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row row-asset hide">
            <div class="col-xs-9">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#file-upload" aria-controls="file-upload" role="tab" data-toggle="tab">Upload</a></li>
                <li role="presentation"><a href="#file-library" aria-controls="file-library" role="tab" data-toggle="tab">Library</a></li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="file-upload">
                  {!! Form::open(['route'=>'adminAssetsUpload', 'id'=>'file-upload-form', 'files'=>true, 'class'=>'hide']) !!}
                  <input type="file" class="hide input-file" name="photos[]" multiple> 
                  {!! Form::close() !!}
                  <div id="file-dropzone" class="dropzone display-table">
                    <div class="display-cell text-center">Drop files here.</div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="file-library">
                  <div class="files" data-url="{{route('adminAssetsAll')}}">
                    <div class="file clone hide" data-id="">
                      <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="load-more text-center">
                    <button type="button" class="btn btn-primary btn-more">Load More</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="loader loader-detail hide">
                <div class="display-table">
                  <div class="display-cell">
                    <div class="spinner"></div>
                  </div>
                </div>
              </div>
              <div class="asset-details hide" data-url="{{route('adminAssetsGet')}}">
                <div class="header">Details</div>
                {!! Form::open(['route'=>'adminAssetsUpdate', 'id'=>'asset-detail-form']) !!}
                  <div class="photo">
                    {{ HTML::image('upload/images/bamboo.jpg') }}
                    <div class="delete">
                      <span class="download-btn">
                        <a href="{{route('adminAssetsDownload')}}">Download</a>
                      </span>
                      <span class="delete-btn">
                        <a href="#">Delete</a>
                      </span>
                      <span class="confirm-btn hide">
                        Are you sure?
                        <a class="confirm-delete-btn" href="{{route('adminAssetsDestroy')}}">Yes</a>
                        &middot;
                        <a href="#">No</a>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    {!! Form::hidden('id', null) !!}
                    {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name']) !!}
                  </div>
                  <div class="form-group">
                    <label for="name">Caption</label>
                    {!! Form::text('caption', null, ['class'=>'form-control', 'id'=>'caption', 'placeholder'=>'Caption']) !!}
                  </div>
                  <div class="form-group">
                    <label for="name">Alt</label>
                    {!! Form::text('alt', null, ['class'=>'form-control', 'id'=>'alt', 'placeholder'=>'Alt']) !!}
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-select" data-dismiss="modal">Select</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>