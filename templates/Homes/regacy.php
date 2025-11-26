
<div class="mb-3">
<ul class="nav">
    <li class="nav-item" style="margin-right:1rem">
        <?= $this->Form->create(null, ['class' => 'd-flex']); ?>
            <input class="form-control me-2" type="search" name="keyword" placeholder="名前、クラス, -1" aria-label="Search">
            <button class="btn btn-outline-success" id="search_btn" type="submit">検索</button>
        </form>
    </li>
    <li class="nav-item" style="margin-right:1rem">
        <form action="/u/a" method="get">
            <button class="btn btn-outline-info" id="a_btn" type="submit">出席者</button>
        </form>
    </li>
</ul>
    <span> -1 は物故者</span>
</div>

<div class="row">
    <p><?= count($results)."件が検索されました"?></p>
<?php

//var_export( $results );
foreach( $results as $r ) {

    if( $r->gone === 0 ) {
        // 生きてる、出席
        $right = ' border-success bg-info c-2023';
        $dark = '';
        $image = $this->Html->image( 'munako/' . $r->class . '/' . $r->no . '.png' , 
            ['class' => 'card-img-top c-2023' ,'data-munako' => $r->class . '/' . $r->no . '.png', 'data-sw' => 'off' ] );

    } else if( $r->gone == 1 ) {

        // 死んでる
        $right = '';
        $dark = ' bg-dark text-white';
        $image = $this->Html->image( 'munako/' . $r->class . '/' . $r->no . '.png' , ['class' => 'card-img-top' ] );
    } else {

        // 不明
        $dark = '';
        $right = '';
        $image = $this->Html->image( 'munako/' . $r->class . '/' . $r->no . '.png' , ['class' => 'card-img-top' ] );
    }
?>

<div class="col-lg-3 col-md-4 col-sm-6">

    <div class="card <?= $dark . $right ?>">
<?php
    echo $image;
?>
        <div class="card-body">
            <p class="card-text fs-4">
                <?= $r->class . '組 : ' . $r->name ?> 
            </p>
        </div><!-- card-body -->
    </div><!-- card -->

</div> <!-- col -->

<?php
}
?>
</div>
<?php
$this->start("myscript");
?>
<script>
$(function() {
    $(".c-2023").click(function(){
        if( $(this).data("sw") == 'off' ){

            $(this).attr("src" , '/img/munako/' + '2023/' + $(this).data('munako') );
            $(this).data("sw", "on");
        } else {

            $(this).attr("src" , '/img/munako/' + $(this).data('munako') );
            $(this).data("sw", "off");
        }
    });
});
</script>
<?php
$this->end();
?>
