<?php

use Lib\Helper\Paging;

?>
<div class="paginationScroller">
  <?= Paging\custom_pagination(); ?>
</div>

<?php
/*  // test
  <ul class="pagination">
    <li class="pagination__item"><a class="prev page-numbers" href="#0"><span>前へ</span></a></li>
    <li class="pagination__item is-rwd">
      <a class="page-numbers" href="#0">1</a>
    </li><li class="pagination__item is-rwd">
      <span class="page-numbers dots">…</span>
    </li><li class="pagination__item is-rwd"><a class="page-numbers" href="#0">3</a></li><li class="pagination__item is-rwd">
      <a class="page-numbers" href="#0">4</a>
    </li><li class="pagination__item">
      <span aria-current="page" class="page-numbers current">5</span>
    </li><li class="pagination__item is-rwd">
      <a class="page-numbers" href="#0">6</a>
    </li><li class="pagination__item">
      <a class="next page-numbers" href="#0"><span>次へ</span></a>
    </li>
  </ul>
*/
?>
