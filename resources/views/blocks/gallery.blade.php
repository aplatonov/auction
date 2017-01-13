    <div class="span12 gallery">
        <!-- Pagination -->
        <div class="no-margin pagination">
            {{ $lots->links('vendor.pagination.default') }}
        </div>

        <div class="row clearfix">
            <ul class="gallery-post-grid holder">
                @forelse ($lots as $lot)
                    <!-- Gallery Item -->
                    <li  class="span3 gallery-item" data-id="id-{{ $lot['id'] }}" data-type="illustration">
                        <span class="gallery-hover-4col hidden-phone hidden-tablet">
                            <span class="gallery-icons">
                                <a href="{{ $lot['images'] != '' ? '/img/gallery/' . $lot['id'] . '/' . $lot['images'] : '/img/noimage.png' }}" class="item-zoom-link lightbox" title="{{ $lot['lot_name'] }}" data-rel="prettyPhoto" rel="prettyPhoto"></a>
                                <a href="/lots/{{ $lot['id'] }}" class="item-details-link"></a>
                            </span>
                        </span>
                        <a href="/lots/{{ $lot['id'] }}"><img src="{{ $lot['images'] != '' ? '/img/gallery/' . $lot['id'] . '/' . $lot['images'] : '/img/noimage.png' }}" alt="{{ $lot['lot_name'] }}"></a>
                        <span class="project-details"><a href="/lots/{{ $lot['id'] }}">{{ $lot['lot_name'] }}</a>{{ $lot['description'] }}</span>
                    </li>
                @empty 
                    <h2 class="title-on-pagination"><small>Отсутствуют лоты выбранного вида</small></h2>
                @endforelse
            </ul>
        </div>
    </div><!-- End gallery list-->