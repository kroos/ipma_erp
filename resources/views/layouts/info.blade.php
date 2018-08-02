<div class="row justify-content-sm-center">
    <div class="col-sm-8">

        @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
        @endif
   </div>
</div>