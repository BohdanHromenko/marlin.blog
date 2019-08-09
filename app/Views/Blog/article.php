<?php $this->layout('layout', ['title' => 'Article']);
$lang = $_SESSION['USER_LANGUAGE'];
$array_uri = explode('/', $_SERVER['REQUEST_URI']);

?>

    <article class="single-blog">
        <div class="post-thumb">
            <img src="/<?=$post->images?>" alt="">
        </div>
        <div class="post-content">
            <div class="entry-header text-center text-uppercase">
                <a href="#" class="post-cat"><?=$categories?></a>
                <h2>
                    <?php foreach ($langTitle as $title_key => $title_val) {
                        if ($title_key == $lang) {
                            if ( $post->$title_val != null ) {
                                echo $post->$title_val;
                            } else {
                                echo $post->title;
                            }
                        }
                    }
                    ?>
                </h2>
            </div>
            <div class="entry-content">
                <p>
                    <?php foreach ( $langDesc as $desc_key => $desc_val ) {
                        if ($desc_key == $lang) {
                            if ( $post->$desc_val != null ) {
                                echo "<p>" . $post->$desc_val . "</p>";
                            } else {
                                echo "<p>" . $post->all_desc . "</p>";
                            }
                        }
                    }
                    ?>
                </p>
            </div>

            <div class="post-meta">
                <ul class="pull-left list-inline author-meta">
                    <li class="author">By <a href="/author/<?=strtolower(str_replace(' ', '_', $author));?>"><?=$author;?> </a></li>
                    <li class="date"> On <?=date("F d, Y", strtotime($post['date']))?></li>
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



            <!--Comments-->

<div class="top-comment"><!--top comment-->
    <img src="/assets/images/comment.jpg" class="pull-left img-circle" alt="">
    <h4><a href="#">Ricard Goff</a></h4>
    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy hello ro mod tempor
        invidunt ut labore et dolore magna aliquyam erat.</p>
    <ul class="list-inline social-share">
        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
    </ul>
</div>
<div class="row"><!--blog next previous-->
    <div class="col-md-6">
        <div class="single-blog-box">
            <a href="/post/<?=$prevSlugCategory?>/<?=$prevPost->slug?>">
                <img src="/<?=$prevPost->images?>" style="max-height: 135px;width: 100%;object-fit: cover;" alt="">
                <div class="overlay">
                    <div class="promo-text">
                        <p><i class=" pull-left fa fa-angle-left"></i></p>
                        <h5>
                            <?php foreach ($langTitle as $title_key => $title_val) {
                                if ($title_key == $lang) {

                                    if ( $prevPost->$title_val != null ) {
                                        echo $prevPost->$title_val;
                                    } else {
                                        echo $prevPost->title;
                                    }
                                }
                            }
                            ?>
                            </h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="single-blog-box">
            <a href="/post/<?=$nextSlugCategory?>/<?=$nextPost->slug?>">
                <img src="/<?=$nextPost->images?>" style="max-height: 135px;width: 100%;object-fit: cover;" alt="">
                <div class="overlay">
                    <div class="promo-text">
                        <p><i class="pull-right fa fa-angle-right"></i></p>
                        <h5>
                            <?php foreach ($langTitle as $title_key => $title_val) {
                                if ($title_key == $lang) {
                                    if ( $nextPost->$title_val != null ) {
                                        echo $nextPost->$title_val;
                                    } else {
                                        echo $nextPost->title;
                                    }
                                }
                            }
                            ?>
                        </h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="related-post-carousel"><!--related post carousel-->
    <div class="related-heading">
        <h4>You might also like</h4>
    </div>
    <div class="related-post-carousel-items">
        <?php foreach($likePost as $item): ?>
        <?php if ( $item['slug'] != $array_uri[3] ): ?>

        <div class="single-item">
            <a href="/post/<?=$thisSlugCategory;?>/<?=$item['slug']?>">
                <img src="/<?=$item['images']?>" style="height: 145px;object-fit: cover;" alt="">
                <h4>
                    <?php foreach ($langTitle as $title_key => $title_val) {
                        if ($title_key == $lang) {
                            if ( $item->$title_val != null ) {
                                echo $item->$title_val;
                            } else {
                                echo $item->title;
                            }
                        }
                    }
                    ?>
                </h4>
            </a>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="leave-comment">
    <h4>Leave a reply</h4>
    <form class="form-horizontal contact-form"   method="post" action="/add_comment">
        <div class="form-group">
            <div class="col-md-6">
                <input name="author" type="text" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="col-md-6">
                <input type="email" name="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <textarea name="description" class="form-control" rows="6" name="message" placeholder="Write Massage" required></textarea>
            </div>
        </div>
        <button name="id" value="<?=$post['id'];?>" type="submit" class="btn send-btn">Post Comment</button>
    </form>
</div>

<div class="comment-area">
    <div class="comment-heading">
        <h3>3 Thoughts</h3>
    </div>
    <div class="single-comment">
        <div class="media">
            <div class="media-left text-center">
                <a href="#"><img class="media-object" src="/assets/images/reply-1.jpg" alt=""></a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <h3 class="text-uppercase">
                        <a href="#">John Smith</a>
                        <a href="#" class="pull-right reply-btn">reply</a>
                    </h3>
                </div>
                <p class="comment-date">
                    December, 02, 2017 at 5:57 PM
                </p>
                <p class="comment-p">
                    Nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sdiam
                    voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
                    gubergren, no sea takimata sanctus est.
                </p>
            </div>
        </div>
    </div>
    <div class="single-comment single-comment-reply">
        <div class="media">
            <div class="media-left text-center">
                <a href="#"> <img class="media-object" src="/assets/images/reply-2.jpg" alt=""></a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <h3 class="text-uppercase"><a href="#">Joan Coal</a></h3>
                </div>
                <p class="comment-date">
                    2 days ago
                </p>
                <p class="comment-p">
                    Labore et dolore magna aliquyam erat, sdiam voluptua. At vero eos eaccusam et justo
                    duo dolores et ea rebum. Stet clita kasd.
                </p>
            </div>
        </div>
    </div>
    <div class="single-comment">
        <div class="media">
            <div class="media-left text-center">
                <a href="#"> <img class="media-object" src="/assets/images/reply-3.jpg" alt=""></a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <h3 class="text-uppercase"><a href="#">Ricard Goff</a> <a href="#"
                                                                              class="pull-right reply-btn">reply</a>
                    </h3>
                </div>
                <span class="comment-date"> 5 hours ago</span>
                <p class="comment-p">
                    Amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidu labore et
                    dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et usto duo
                    dolores et ea rebum.
                </p>
            </div>
        </div>
    </div>
</div>
<!--leave comment-->

