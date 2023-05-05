<?php
session_start();

require("connect.php");

$sql="SELECT users.username, users.avatar, posts.id, posts.title, posts.body, posts.thumbnail, posts.date_time,categories.name
FROM users
JOIN posts ON users.id = posts.author_id
JOIN categories ON posts.category_id = categories.id";

$result=mysqli_query($conn,$sql);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Blog</title>
</head>
<body>


    <div class="container">
        <div class="header">
        <a href="index.php" class="logo">Blogg<span>Y</span></a>
            <form action="search.php" method="GET" class="d-flex">
                <input type="search" name="search" placeholder="search blog" id="">
                <button type="submit" name="submit" class="button">search</button>
            </form>
            <div class="auth">
            <?php
                    

                    // Check if user is logged in
                    if (isset($_SESSION['username'])) {
                       $username= $_SESSION['username'];
                        echo '<div class="d-flex">
                        <a href="#" class="user-name">' .$username. '</a>
                        <a href="user-profile.php" class="user-name">Dashboard</a>
                        <form method="post" action="logout.php">
                        <button type="submit" name="logout" class="button" style="margin-left:.5rem;">Logout</button>
                    </form>
                    </div>';

                    // If user is logged in, hide the login and signup buttons
                    echo "<script>document.getElementById('login-btn').style.display = 'none';</script>";
                    echo "<script>document.getElementById('signup-btn').style.display = 'none';</script>";
                    } else {
                    // If user is not logged in, show the login and signup buttons
                    echo "<a class='button' id='login-btn' href='login.php' style='--color:#1e9bff;'>LogIn</a>";
                    echo '<a class="button" id="signup-btn" href="signup.php" style="--color: #3e41ff; margin-left: 1rem">SignUp</a>';
                    }
?>
            </div>
        </div>
    </div>


<div class="container">
    <div class="post-container">
        <h2 class="heading">Blogs</h2>
      
        <?php if($result){
    while($row=mysqli_fetch_assoc($result)){ ?>
            <div class="posts">
                <div class="user-img">
                    <img src="<?php echo "images/".$row['avatar'] ?>" class="u-img" alt="" srcset="">
                    <a href="#" class="user-name"><?php echo $row['username']; ?></a>
                    <span class="user-date">
                        <?php 
                        $date_time = $row['date_time'];
                    $formatted_date = date("M j, Y", strtotime($date_time));
                        echo  "- ".$formatted_date;

                        ?>
                    </span>
                </div>
                <div class="post-main">
                    <div class="post-text">
                        <h3 class="title"><?php echo $row['title']; ?></h3>
                        <p class="text">
                            <?php
                            $mytext=$row['body']; 
                            $num_words=25;
                            $words=explode(" ",$mytext);
                            $short_text = implode(" ",array_slice($words,0,$num_words));
                            echo $short_text."...."; 
                            ?>
                        </p>
                        <div class="category d-flex">
                            <a href="read-post.php?id=<?php echo $row['id']; ?>" class="btn">Read More..</a>
                                <a href="" class="cat"><?php echo $row['name']; ?></a>
                                <p class="time">. 5 min read</p>
                        </div>
                    </div>
                    <img src="<?php echo "postimages/".$row['thumbnail']; ?>" alt="">
                </div>        
            </div>
            <?php 
                }
            }
            ?>
        
    </div>
</div>

</body>
</html>