
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

    // 複数あるかもしれない出席情報
    $class_str = "" ;
    $attend_str = "" ;
    foreach( $r->attends as $a ) {
        
        if( $a->attend_year == 2023 ) {
            $class_str .= "c-2023" ;
            $attend_str .= "(2023)" ;
        }
        if( $a->attend_year == 2027 ) {
            $class_str .= "c-2027" ;
            $attend_str .= "(2027)" ;
        }
    }

    // 死んでるか生きてるか
    if( $r->gone == 1 ) {
        // 死んでる
        $right = '';
        $dark = ' bg-dark text-white';
        $image = $this->Html->image( 'munako/' . $r->class . '/' . $r->no . '.png' , ['class' => 'card-img-top' ] );

    } else if( $class_str != "" ) { // 出席したことがある
        // 生きてる、出席
        $right = ' border-success bg-info '.$class_str;
        $dark = '';
        $image = $this->Html->image( 'munako/' . $r->class . '/' . $r->no . '.png' , 
            ['class' => 'card-img-top '.$class_str ,'data-munako' => $r->class . '/' . $r->no . '.png', 'data-sw' => 'off' ] );

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
                <?= $r->class . '組 : ' . $r->name ." ".$attend_str ?>  
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
$imgBasePath = $this->Url->build('/img/munako/', ['fullBase' => false]);
?>
<script>
$(function() {
    var imgBasePath = '<?= $imgBasePath ?>';
    $(".c-2023").click(function(){
        if( $(this).data("sw") == 'off' ){

            $(this).attr("src" , imgBasePath + '2023/' + $(this).data('munako') );
            $(this).data("sw", "on");
        } else {

            $(this).attr("src" , imgBasePath + $(this).data('munako') );
            $(this).data("sw", "off");
        }
    });
});
</script>
<?php
$this->end();
?>
