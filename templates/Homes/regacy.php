  <?php
    // レガシーシステムのログイン後のページ
  ?>
  <?= $title ?>
  <div class="top">
   <?=
      $this->Html->image( "prosp-01-01.jpg");
   ?>
  </div> 

  <div class="container">
    <h1>完全版天命タロット鑑定</h1>

    <?= $this->Form->create(null, ['url' => [
      'action' => 'regacyResult',
      'controller' => 'Homes',
      ]]) ?>

    <div class="box">
      <h5>あなたが天命にブレずに生きる方法がわかります</h5>
      <h4>あなたの生年月日を入力</h4>
     <div class="input-group">
       <div class="input-row">
        <select id="year" name="year"></select>
        <label for="year">年</label>
       </div>
       <div class="input-row">
        <select id="month" name="month"></select>
        <label for="month">月</label>
       </div>
       <div class="input-row">
        <select id="day" name="day"></select>
        <label for="day">日</label>
       </div>
      </div>
    </div>
  </div>

  <div class="button-row">
    <button type="submit">
      <?= $this->Html->image("probutton01.png");?>
    </button>
  </div>

  <?= $this->Form->end() ?>
  
  <div class="talent">
    <p id="talentText"></p>
  </div>
  
    <font color="white">生年月日であなたの<br>「天命」「才能」「弱点」が分かります。</font>
    <br><br>
<div class="container2">
  <div class="title">
    たかとうさきの天命タロットとは？
  </div>
  <div class="explanation">
    <br>
    たかとうさきの天命タロットは、<br>
    これまでのタロット占いとはまったく違う、<br>
    オリジナルの占術方式です。<br>
    <br>
    人は皆、天命を授けられ<br>
    「この人生でこれをやります！」と<br>
    納得して生まれてきます。<br>
    天命はこの世に誕生した日にちに隠されていて<br>
    あなたが生まれてきた意味(天命)<br>
    天命に生きるための武器(才能)
    天命に生きることを邪魔する己の弱さ(弱点)<br>
    の3つが、タロットカードに紐付けられています。 <br> <br> 
  </div>
  <div class="tenmei">
    <br>
    天命がわかれば、恋愛も仕事も、<br>
    もう二度と迷うことはありません。<br>
    本当の自分らしさを思い出し<br>
    より豊かに、最高に幸せな人生を<br>
    歩むことができるのです。<br><br> 
  </div>
</div>

<?= $this->Html->script("projavascript") ?>
