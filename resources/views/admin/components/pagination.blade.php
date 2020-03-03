<div class="kt-pagination  kt-pagination--brand">
  @if ($datas->lastPage() > 1)
    <ul class="kt-pagination__links">
      @if (!$datas->onFirstPage())
        <li class="kt-pagination__link--first {{ ($datas->currentPage() == 1) ? ' disabled' : '' }}">
          <a href="{{ $datas->url(1) . $filter}}"><i class="fa fa-angle-double-left kt-font-brand"></i></a>
        </li>
        <li class="kt-pagination__link--next">
            <a href="{{$datas->previousPageUrl() . $filter}}"><i class="fa fa-angle-left kt-font-brand"></i></a>
        </li>
      @endif
      @for ($i = 1; $i <= $datas->lastPage(); $i++)
        <?php
          $half_total_links = floor($link_limit / 2);
          $from = $datas->currentPage() - $half_total_links;
          $to = $datas->currentPage() + $half_total_links;
          if ($datas->currentPage() < $half_total_links) {
            $to += $half_total_links - $datas->currentPage();
          }
          if ($datas->lastPage() - $datas->currentPage() < $half_total_links) {
            $from -= $half_total_links - ($datas->lastPage() - $datas->currentPage()) - 1;
          }
        ?>
        @if ($from < $i && $i < $to)
          <li class="{{ ($datas->currentPage() == $i) ? 'kt-pagination__link--active' : '' }}">
            <a href="{{ $datas->url($i) }}{{$filter}}">{{ $i }}</a>
          </li>
        @endif
      @endfor
      @if ($datas->hasMorePages())
        <li class="kt-pagination__link--prev">
            <a href="{{$datas->nextPageUrl()}}{{$filter}}"><i class="fa fa-angle-right kt-font-brand"></i></a>
        </li>
        <li class="kt-pagination__link--last{{ ($datas->currentPage() == $datas->lastPage()) ? ' disabled' : '' }}">
          <a href="{{ $datas->url($datas->lastPage()) }}{{$filter}}"><i class="fa fa-angle-double-right kt-font-brand"></i></a>
        </li>
      @endif
    </ul>
  @endif
  <div class="kt-pagination__toolbar ml-auto">
    <span class="pagination__desc">Menampilkan {{ ($datas->perPage() > $datas->total()) ? $datas->total() : $datas->perPage() }} dari {{ $datas->total() }}</span>
  </div>
</div>