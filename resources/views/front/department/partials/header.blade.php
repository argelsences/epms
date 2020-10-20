<section id="intro" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="organiser_logo">
                <div class="thumbnail">
                    <img src="{{ '/'}}" />
                </div>
            </div>
            <h1>{{$department->name}}</h1>
            @if($department->about)
            <div class="description pa10">
                {!! $department->about !!}
            </div>
            @endif
        </div>
    </div>
</section>