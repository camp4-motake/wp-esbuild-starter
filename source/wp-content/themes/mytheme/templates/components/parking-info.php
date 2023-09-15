<?php

// TODO  駐車場API出力 確定待ち

$endpoint = get_rest_url(null, 'mytheme/v1/parking');

?>
<div class="parking-info" x-data="parkingData('<?= esc_url($endpoint) ?>')">
  <h3 class="parking-info-heading -car"><i role="presentation"></i>駐車場ご利用状況</h3>
  <p class="text-size-md text-center"><button type="button" class="parking-info-update" x-bind="updateBtn">リアルタイム更新</button></p>
  <dl class="parking-status-list">
    <dt>P1</dt>
    <!-- TODO ダミー -->
    <dd class="badge -loading" x-data="parkingStatus('第一駐車場')" x-bind="label"></dd>
    <dt>P2</dt>
    <dd class="badge -loading" x-data="parkingStatus('')" x-bind="label"></dd>
    <dt>P4</dt>
    <dd class="badge -loading" x-data="parkingStatus('')" x-bind="label"></dd>
  </dl>
</div>
