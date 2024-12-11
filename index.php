<?php
session_start();

include("include/connection.php");

class Exhibit {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAcceptedExhibits() {
        $statement = $this->conn->prepare(  "
            SELECT 
                exhibit_tbl.exbt_title, 
                exhibit_tbl.exbt_descrip, 
                art_info.title AS artwork_title, 
                art_info.description AS artwork_description, 
                art_info.file AS artwork_file, 
                art_info.u_id AS artist_id, 
                accounts.u_name AS u_name 
            FROM exhibit_tbl
            INNER JOIN exhibit_artworks ON exhibit_tbl.exbt_id = exhibit_artworks.exbt_id
            INNER JOIN art_info ON exhibit_artworks.a_id = art_info.a_id
            INNER JOIN accounts ON art_info.u_id = accounts.u_id
            WHERE exhibit_tbl.exbt_status = 'Ongoing'
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

$exhibit = new Exhibit($conn);
$acceptedExhibits = $exhibit->getAcceptedExhibits();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style-home.css">
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <title>Virtual Art Gallery</title>
</head>
<body>

        <header>
        <div class="logo">
            <img src="gallery/image/vags-logo.png" alt="Worxist Logo">
        </div>
        <div class="navbar">
            <a href="#home-page">HOME <span></span></a>
            <a href="#about">ABOUT <span></span></a>
            <a href="#gallery">GALLERY <span></span></a>
            <a href="login-register.php">LOGIN <span></span></a>
        </div>
    </header>
 
    <div class="wrapper">

        <!-- HOME SECTION -->
        <section id="home-page">
            <div class="left-description">
                <h3>YOUR VERSION OF <br><span>DESIGN</span></h3>
                <p>Explore, appreciate, and be inspired by a diverse range of styles and mediums.  Step inside and let the art speak to you.</p>

                <div class="explore-button">
    <button onclick="scrollToAbout()">Explore More</button>
</div>

                <div class="small-circle">
                </div>
            </div>

            <!-- Right Image -->
            <div class="right-image">
                 <div class="circle">
                </div>
                <div class="zues">
                      <img src="gallery/image/greek god (1).png" alt="zeus">  
                </div>
              
            </div>
              
        </section>
          
        <!-- ABOUT SECTION -->
    
        <section id="about">-
            <div class="picture">
                <img src="gallery/image/about-image (1).png" alt="Artwork">
            </div>
    
            <div class="right-description">
                <h5>ABOUT US.</h5>
                <br>
                <hr>
                <br>
                <h1>Your <span>art.</span></h1>
                <h1>Our <span>platform</span></h1>
                <br>
                <p>The Worxist serves as a dynamic stage for aspiring artists and art enthusiasts alike. This platform celebrates creativity by connecting emerging talents with those who appreciate the beauty of art. Dive into a world of imagination and expression, where every piece tells a story and every visit inspires new perspectives.</p>
                <br>
             
                <div class="contact">
                    <div class="icon-contact">
                    <i class='bx bxs-envelope' style='color:#ff0000' ></i>    
                    </div>
                    <p>Contact Us</p>
                </div>
                
            </div>
        </section>
        <br><br><br><br><br>

        <!-- GALLERY SECTION -->
<section id="gallery">
    <div class="gallery-container">
        
        <div class="gallery-title">
            <h1>GALLERY</h1>
            <p>Explore our collection</p>
        </div>

        <div class="arrow">
            <i id="left" class='bx bx-chevron-left'></i>
            <i id="right" class='bx bx-chevron-right'></i>
        </div>

        <div class="gallery-images">
        <?php
                    if (empty($acceptedExhibits)) {
                        $defaultImages = [
                            ["file" => "rose.png", "title" => "Roses", "artist" => "Maya Kulenovic", "description" => "The original sculpture is hand sculpted by the artist in clay or carved in plaster to a polished finish. This master is used to..."],
                            ["file" => "head.png", "title" => "Sleeper", "artist" => "Maya Kulenovic", "description" => "The original sculpture is hand sculpted by the artist in clay or carved in plaster to a polished finish. This master is used to..."],
                            ["file" => "paris.png", "title" => "Paris", "artist" => "Maya Kulenovic", "description" => "The original sculpture is hand sculpted by the artist in clay or carved in plaster to a polished finish. This master is used to..."],
                            ["file" => "guitar.jpg", "title" => "Roses", "artist" => "Maya Kulenovic", "description" => "The original sculpture is hand sculpted by the artist in clay or carved in plaster to a polished finish. This master is used to..."]
                        ];

                        foreach ($defaultImages as $image) {
                            ?>
                            <div class="card">
                                <img src="gallery/<?php echo $image['file']; ?>" alt="Head">
                                <div class="title-card">
                                    <p><span><?php echo $image['title']; ?></span><br>by <?php echo $image['artist']; ?></p>
                                </div>
                                <div class="description">
                                    <br>
                                    <p><?php echo $image['description']; ?></p>
                                    <button id="explore">Explore</button>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        foreach ($acceptedExhibits as $exhibit) {
                            $artworkTitle = htmlspecialchars($exhibit['artwork_title']);
                            $artworkDescription = htmlspecialchars($exhibit['artwork_description']);
                            $artworkFile = htmlspecialchars($exhibit['artwork_file']);
                            $artistName = htmlspecialchars($exhibit['u_name']);
                            ?>
                            <div class="card">
                                <img src="<?php echo $artworkFile; ?>" alt="<?php echo $artworkTitle; ?>">
                                <div class="title-card">
                                    <p><span><?php echo $artworkTitle; ?></span><br>by <?php echo $artistName; ?></p>
                                </div>
                                <div class="description">
                                    <br>
                                    <p><?php echo $artworkDescription; ?></p>
                                    <button id="explore">Explore</button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
        </div>
    </div>
</section>



    <footer>
        <div class="icon-wrapper">

            <div class="button">
                <div class="icon"><i class='bx bxl-meta'></i>
                <span>Meta</span></div>
            </div>

            <div class="button">
                <div class="icon"><i class='bx bxl-instagram-alt' ></i>
                <span>Instagram</span></div>
            </div>

            <div class="button">
                <div class="icon"><i class='bx bxl-twitter'></i>
                <span>Twitter</span></div>
            </div>
       
          

        </div>
    </footer>

        <!-- end of wrapper -->
    </div>
    <script src="js/dashboard.js " ></script>
</body>
</html>