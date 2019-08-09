<?php $this->layout('layout', ['title' => 'category']);
$lang = $_SESSION['USER_LANGUAGE'];
?>


<?php foreach ( $articles as $article ):?>
    <?php foreach ( $categories as $category ):?>
        <?php foreach ($authors as $author_id => $author_title):?>
            <?php if ($category['id'] == $article['category_id']): ?>
                <?php if ($author_id == $article['author']): ?>

<article class="single-blog">
    <div class="post-thumb">
        <a href="/post/<?=$category['slug']?>/<?=$article['slug']?>"><img src="/<?=$article['images']?>" alt=""></a>
    </div>
    <div class="post-content">
        <div class="entry-header text-center text-uppercase">
            <a href="/category/<?=$category['slug']?>" class="post-cat"><?=$category['title']?></a>
            <h2><a href="/post/<?=$category['slug']?>/<?=$article['slug']?>">
                    <?php foreach ($langTitle as $title_key => $title_val) {
                        if ($title_key == $lang) {
                            echo $article->$title_val;
                        }
                    }
                    ?>
                </a></h2>
        </div>
        <div class="entry-content">
            <?php foreach ( $langDesc as $desc_key => $desc_val ) {
                if ($desc_key == $lang) {
                    echo "<p>" . mb_strimwidth($article->$desc_val, 0, 500, '...') . "</p>";
                }
            }
            ?>
        </div>
        <div class="continue-reading text-center text-uppercase">
            <a href="/post/<?=$category['slug']?>/<?=$article['slug']?>">Continue Reading</a>
        </div>
        <div class="post-meta">
            <ul class="pull-left list-inline author-meta">
                <li class="author">By <a href="/author/<?=strtolower(str_replace(' ', '_', $author_title));?>"><?=$author_title;?> </a></li>
                <li class="date"> On <?=date("F d, Y", strtotime($article['date']))?></li>
            </ul>
            <ul class="pull-right list-inline social-share">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</article>
                <?php
                    $slug = strtolower(str_replace(' ', '_', $author_title));
                ?>

                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>

    <!--PAGINATION-->
<div class="post-pagination  clearfix">
    <ul class="pagination text-left">
        <?php for ($i = 1; $i <= $amountPages; $i++) :?>
        <li <?php if ($i == $numberOfPages) echo "class='active'"; if($amountPages == 1) echo "style='display:none;'";?>><a href="/author/<?=$slug?>/<?=$i?>"><?=$i?></a></li>
        <?php endfor; ?>
        <li <?php if($amountPages == $numberOfPages || $amountPages == 1) echo "style='display:none;'";?>><a href="/author/<?=$slug?>/<?=$numberOfPages+1?>"><i class="fa fa-angle-double-right"></i></a></li>
    </ul>
</div>


