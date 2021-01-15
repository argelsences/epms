<section id="details" class="container">
    <div class="row">
        <h1 class="section_head">
            Event Details
        </h1>
    </div>
    <div class="row">
        @php
            $descriptionColSize =  ($event->poster) ? '7' : '12';
        @endphp

        @if ($event->poster)
            <div class="col-md-5">
                <div class="content event_poster">
                    <v-img src="/{{$event->poster->file_path}}" property="image" alt="{{$event->title}}"></v-img>
                    @if(Storage::exists('files/events/'. $event->id . '/poster/' . $event->id . '.pdf'))
                        <a href="{{ Storage::disk('public')->url('/files/events/' . $event->id . '/poster/' . $event->id .'.pdf') }}" download style="text-align:right;">
                            <v-icon>mdi-file-pdf-outline</v-icon>
                            DOWNLOAD PDF
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <div class="col-md-{{ $descriptionColSize }}">
            <div class="content event_details" property="description">
                {!! clean($event->synopsis) !!}
            </div>
        </div>
    </div>
</section>
