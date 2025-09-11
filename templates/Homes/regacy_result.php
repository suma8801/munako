<?php
  // レイアウトのタイトルとスタイルファイル名は、コントローラでセットする

  // コントローラから渡された結果
  $talent    = $result_set['talent'];
  $destiny   = $result_set['destiny'];
  $weakness  = $result_set['weakness'];
  $weakness2 = $result_set['weakness2'];

?>
          <h1>あなたの<br><br>才能は...</h1>
          <div class="result-content">
            <h2 id="talent-title">
              <?= $talent->card_title ?><br>
              <?= $talent->etitle ?>
            </h2>
            <div class="result-row">
              <?=
                $this->Html->image($talent->card_image,['id'=>"talent-image","alt"=>"Card Image"]);
              ?>
              <div id="talent-short-text"><?= $talent->short_text ?></div>
            </div>
            <div class="ltext" id="talent-long-text"><?= $talent->long_text ?></div>
          </div>
          <h1>あなたの<br><br>弱点は...</h1>
          <div class="result-content">
            <h2 id="weakness-title">
              <?= $weakness->card_title ?><br>
              <?= $weakness->etitle ?>
            </h2>
            <div class="result-row">
              <?=
                $this->Html->image($weakness->card_image,['id'=>"weakness-image","alt"=>"Card Image"]);
              ?>
              <div id="weakness-short-text"><?= $weakness->short_text ?></div>
            </div>
            <div class="ltext" id="weakness-long-text"><?= $weakness->long_text ?></div>
          </div>
          <h1>あなたの<br><br>天命は...</h1>
          <div class="result-content">
            <h2 id="destiny-title">
              <?= $destiny->card_title ?><br>
              <?= $destiny->etitle ?>
            </h2>
            <div class="result-row">
              <?=
                $this->Html->image($destiny->card_image,['id'=>"destiny-image","alt"=>"Card Image"]);
              ?>
                <div id="destiny-short-text"><?= $destiny->short_text ?></div>
              </div>
              <div class="ltext" id="destiny-long-text"><?= $destiny->long_text ?></div>
            </div>
         
          <!-- 現在の弱点の結果セクションの下に追加 -->
           <?php
            if( $weakness2 != null ):
           ?>
            <div class="result-content" id="second-weakness-section" >
              <h1>もう1つのあなたの<br><br>弱点は...</h1>
              <h2 id="second-weakness-title">
                <?= $weakness2->card_title ?><br>
                <?= $weakness2->etitle ?>
              </h2>
              <div class="result-row">
              <?=
                $this->Html->image($weakness2->card_image,['id'=>"second-weakness-image","alt"=>"Card Image"]);
              ?>
                <div id="second-weakness-short-text"><?= $weakness2->short_text ?></div>
              </div>
              <div class="ltext" id="second-weakness-long-text"><?= $weakness2->long_text ?></div>
            </div>
            <?php
              endif;
            ?>
    </div>
