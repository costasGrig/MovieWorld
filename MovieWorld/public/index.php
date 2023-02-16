<?php
    require_once __DIR__ . '../../boot/boot.php';

    use Movie\Post;
    use Movie\User;
    use Movie\Preference;

    $post = new Post();
    $user = new User();
    $preference = new Preference();

    $currentUser = $user->getByUserId(User::getCurrentUserId());

    $renderPosts = $post->allPosts();

    if(isset($_REQUEST['movie_likes'])){
        $renderPosts = $post->sortPostByLike();
    }

    if(isset($_REQUEST['movie_hates'])){
        $renderPosts = $post->sortPostByHate();
    }

    if(isset($_REQUEST['publication_date'])){
        $renderPosts = $post->sortPostByDate();
    };

    if(isset($_REQUEST['author'])){
        $renderPosts = $post->authorPost($_REQUEST['author']);
    };

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie World</title>
    <link rel="icon" type="image/x-icon" href="assets/icon/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li class="logo">Movie World</li>
            <?php echo empty(User::getCurrentUserId()) ? '<li class="signup rightfloat"><a href="signup.php">Sign up</a></li>' :'<li class="login rightfloat"><i class="user-name">'.$currentUser['name'].'</i></li>';?>
            <li class="login rightfloat"><?php echo empty(User::getCurrentUserId()) ? '<a href="login.php">Log in</a> or' :'Welcome back';?></li>            
        </ul>
    </nav>
    <div class="count">Found <?php echo count($renderPosts); ?> movies</div>
    <main>
        <div class="userpost">
            <?php 
                foreach ($renderPosts as $renderPost){
                    $isPreference = $preference->isPreference(User::getCurrentUserId(),$renderPost['movie_id']);
            ?>
            <div class="usersection">
                <span class="posttitle"><?php echo $renderPost['title']; ?></span>
                <span class="postdate rightfloat"><?php echo 'Posted '.$renderPost['publication_date']; ?></span>
                <p>
                <?php echo $renderPost['description']; ?>
                </p>
                <div class="lowerdivision">
                    <div>
                        <span class="postlike <?php if($isPreference['user_like'] == 1){ echo 'like-color';} ?>"><?php echo $renderPost['movie_likes'].' likes';?></span>
                        <span>|</span>
                        <span class="posthate <?php if($isPreference['user_hate'] == 1){ echo 'hate-color';} ?>"><?php echo $renderPost['movie_hates'].' hates';?></span>
                    </div>
                    <?php if(User::getCurrentUserId() !== $renderPost['user_id']  && !empty(User::getCurrentUserId())){ ?>
                        <div class="preference-area">
                            <form method="POST" action="actions/preference.php">
                                <input type="hidden" name="user_id" value='<?php echo User::getCurrentUserId() ?>'/>
                                <input type="hidden" name="movie_id" value='<?php echo $renderPost['movie_id'] ?>'/>
                                <input type="hidden" name="user_like" value='1'/>
                                <input type="hidden" name="user_hate" value='0'/>
                                <input class="preference-button <?php if($isPreference['user_like'] == 1){ echo 'preference';} ?> center" type="submit" value="Like"></input>
                            </form>
                            <span class="center">|</span>
                            <form method="POST" action="actions/preference.php">
                                <input type="hidden" name="user_id" value='<?php echo User::getCurrentUserId() ?>'/>
                                <input type="hidden" name="movie_id" value='<?php echo $renderPost['movie_id'] ?>'/>
                                <input type="hidden" name="user_like" value='0'/>
                                <input type="hidden" name="user_hate" value='1'/>
                                <input class="preference-button <?php if($isPreference['user_hate'] == 1){ echo 'preference';} ?> center" type="submit" value="Hate"></input>
                            </form>
                        </div>
                    <?php }?>
                    <div>
                        <span class="postauthor rightfloat">
                        Posted by
                            <a href="<?php echo 'index.php?author='.$renderPost['email'] ?>">
                                <b>
                                    <?php echo (User::getCurrentUserId() == $renderPost['user_id']) ? 'You' : $renderPost['name']; ?> 
                                </b>
                            </a>
                        </span>
                    </div>  
                </div>
            </div>            
            <?php  
            } 
            ?>
        </div>   
        <aside>
            <?php if(!empty(User::getCurrentUserId())){ ?>
                <div class="new_button center">
                    <a href="insert.php"><b>New Movie</a>
                </div>
            <?php } ?>
            <div class="filter">
                <h3 class="filterstyle no-border">Sort by:</h3>
                <div class="filterstyle">
                    <form action="index.php" method="get">
                        <button type="submit" value="movie_likes" name="movie_likes">Likes <?php echo (isset($_REQUEST['movie_likes']) ? '&#x1F5F9;' : '&#9744;') ?></button>
                    </form>
                </div>
                <div class="filterstyle">
                    <form action="index.php" method="get">
                        <button type="submit" value="movie_hates" name="movie_hates">Hates <?php echo (isset($_REQUEST['movie_hates']) ? '&#x1F5F9;' : '&#9744;') ?></button>
                    </form>
                </div>
                <div class="filterstyle">
                    <form action="index.php" method="get">
                        <button type="submit" value="publication_date" name="publication_date">Date <?php echo (isset($_REQUEST['publication_date']) ? '&#x1F5F9;' : '&#9744;') ?></button>
                    </form>
                </div>
            </div>
        </aside>
    </main>
</body>
</html>