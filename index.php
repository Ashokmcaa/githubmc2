<?php
include 'config.php';

// Fetch data for display
$stmt = $conn->query("SELECT * FROM content");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DelphianLogic in Action</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #c4351e;
            --brand-secondary: #11324d;
            --brand-third: #f0b91e;
            --brand-fourth: #64b4c8;
            --brand-fifth: #504682;
            --brand-sixth: #2fb1fc;
            --gray-darker: #2e3439;
            --gray-dark: #424242;
            --gray: #696969;
            --gray-light: #adadad;
            --gray-lighter: #d4d3d8;
            --gray-white: #f6f6f6;
            --br-5: 5px;
            --pad-2: 10px;
            --pad-3: 12px;
            --gap-2: 10px;
            --gap-3: 15px;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--brand-secondary);
            color: var(--brand-white);
            margin: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Titillium Web', sans-serif;
        }

        .header {
            padding: var(--pad-3);
            text-align: center;
            color: #fff;
        }

        .header h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: var(--gap-2);
        }

        .header p {
            font-size: 13px;
            color: var(--gray-light);
            margin: 0;
        }

        .tab-section {
            background-color: var(--gray-white);
            color: var(--gray-dark);
            border-radius: var(--br-5);
            margin: var(--gap-2);
            position: relative;
        }

        .tab-section .nav-link {
            color: var(--gray-dark);
            padding: var(--pad-2);
            border-radius: var(--br-5);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: var(--gap-2);
        }

        .tab-section .nav-link.active {
            background-color: var(--brand-white);
            color: var(--gray-dark);
            position: relative;
        }

        .tab-section .nav-link.active::after {
            content: '';
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 10px solid var(--brand-white);
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
        }

        .tab-section .nav-link img {
            width: 20px;
            height: 20px;
        }

        .slider-section {
            background-color: var(--brand-fourth);
            color: var(--brand-white);
            padding: var(--pad-3);
            border-radius: var(--br-5);
            margin: var(--gap-2);
            position: relative;
        }

        .slider-section small {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .slider-section h3 {
            font-size: 20px;
            font-weight: 600;
            margin: var(--gap-2) 0;
        }

        .slider-section p {
            font-size: 14px;
            margin-bottom: var(--gap-2);
        }

        .slider-section a {
            color: var(--brand-white);
            text-decoration: none;
            font-size: 14px;
        }

        .image-section img {
            width: 100%;
            height: auto;
            border-radius: var(--br-5);
            aspect-ratio: 11 / 1;
        }

        .carousel-indicators {
            bottom: -30px;
            margin: 0;
        }

        .carousel-indicators button {
            background-color: var(--gray-light);
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .carousel-indicators .active {
            background-color: var(--brand-white);
        }

        #contentTabContent {
            color: #fff !important;
        }

        .accordion-button {
            background-color: var(--gray-white);
            color: var(--gray-dark);
            font-size: 14px;
            padding: var(--pad-2);
            border-radius: var(--br-5) !important;
            display: flex;
            align-items: center;
            gap: var(--gap-2);
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--gray-white);
            color: var(--gray-dark);
            box-shadow: none;
        }

        .carousel {
            color: #fff !important;
        }

        .accordion-button::after {
            background-image: url("images/minus-01.svg");
            width: 20px;
            height: 20px;
        }

        .accordion-button:not(.collapsed)::after {
            background-image: url("images/plus-01.svg");
        }

        .accordion-item {
            background-color: transparent;
            border: none;
            margin-bottom: var(--gap-2);
        }

        .accordion-body {
            padding: 0;
        }

        .carousel-item {
            background-size: cover;
            background-position: center;
            min-height: 300px; /* Ensure the background image is visible */
        }

        @media (min-width: 992px) {
            .desktop-layout {
                display: flex;
                gap: var(--gap-3);
                padding: 0 var(--pad-3);
            }

            .tab-section {
                width: 20%;
                margin: 0;
            }

            .slider-section {
                width: 40%;
                margin: 0;
                background-color: #64b4c8 !important;
            }

            .image-section {
                width: 40%;
                margin: 0;
            }

            .header h1 {
                font-size: 40px;
            }

            .header p {
                font-size: 14px;
            }

            .slider-section small {
                font-size: 14px;
            }

            .slider-section h3 {
                font-size: 24px;
            }

            .slider-section p, .slider-section a {
                font-size: 16px;
            }
        }

        .image-section {
            display: inline-flex;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <h1>DelphianLogic in Action</h1>
            <p style="color:#fff">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo</p>
        </div>

        <!-- Mobile View -->
        <div class="mobile-view d-lg-none">
            <div class="accordion" id="accordionContent">
                <?php foreach ($data as $index => $item): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo htmlspecialchars($item['category']); ?>">
                            <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo htmlspecialchars($item['category']); ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo htmlspecialchars($item['category']); ?>" data-category="<?php echo htmlspecialchars($item['category']); ?>">
                                <img src="<?php echo htmlspecialchars($item['svg_path']); ?>" alt="<?php echo htmlspecialchars($item['category']); ?> Icon">
                                <?php echo htmlspecialchars($item['category']); ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo htmlspecialchars($item['category']); ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading<?php echo htmlspecialchars($item['category']); ?>" data-bs-parent="#accordionContent">
                            <div class="accordion-body">
                                <div id="carousel<?php echo htmlspecialchars($item['category']); ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carousel<?php echo htmlspecialchars($item['category']); ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active" style="background-image: url('<?php echo htmlspecialchars($item['image_path']); ?>');">
                                            <div class="slider-section">
                                                <small><?php echo htmlspecialchars($item['subtitle']); ?></small>
                                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                                <p><?php echo htmlspecialchars($item['description']); ?></p>
                                                <a href="#">Learn More →</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Desktop View -->
        <div class="desktop-layout d-none d-lg-flex">
            <div class="tab-section">
                <ul class="nav flex-column" id="contentTabs" role="tablist">
                    <?php foreach ($data as $index => $item): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" id="<?php echo htmlspecialchars(strtolower($item['category'])); ?>-tab" data-bs-toggle="tab" href="#<?php echo htmlspecialchars(strtolower($item['category'])); ?>" role="tab" aria-controls="<?php echo htmlspecialchars(strtolower($item['category'])); ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-category="<?php echo htmlspecialchars($item['category']); ?>">
                                <img src="<?php echo htmlspecialchars($item['svg_path']); ?>" alt="<?php echo htmlspecialchars($item['category']); ?> Icon">
                                <?php echo htmlspecialchars($item['category']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="tab-content slider-section" id="contentTabContent">
                <?php foreach ($data as $index => $item): ?>
                    <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="<?php echo htmlspecialchars(strtolower($item['category'])); ?>" role="tabpanel" aria-labelledby="<?php echo htmlspecialchars(strtolower($item['category'])); ?>-tab">
                        <div id="carousel<?php echo htmlspecialchars($item['category']); ?>Desktop" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carousel<?php echo htmlspecialchars($item['category']); ?>Desktop" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <small><?php echo htmlspecialchars($item['subtitle']); ?></small>
                                    <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                                    <a href="#">Learn More →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="image-section">
                <img src="<?php echo htmlspecialchars($data[0]['image_path']); ?>" alt="Content Image" id="contentImage">
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store content data for quick lookup
            const contentData = <?php echo json_encode($data); ?>;

            // Function to update images
            function updateImage(category) {
                console.log("Updating image for category:", category);
                const item = contentData.find(d => d.category === category);
                if (item) {
                    console.log("Found item:", item);
                    // Update desktop image (Column 3)
                    $('#contentImage').attr('src', item.image_path);
                    // Update mobile background image
                    const carousel = $(`#carousel${category}`);
                    if (carousel.length) {
                        carousel.find('.carousel-item').css('background-image', `url(${item.image_path})`);
                    } else {
                        console.log("Carousel not found for category:", category);
                    }
                } else {
                    console.log("Item not found for category:", category);
                }
            }

            // Initial load: Set the image for the first tab/accordion item
            const firstCategory = contentData[0]?.category;
            if (firstCategory) {
                updateImage(firstCategory);
            }

            // Update image on tab change (Desktop)
            $('#contentTabs a').on('shown.bs.tab', function(e) {
                const category = $(e.target).data('category');
                console.log("Tab changed to:", category);
                updateImage(category);
            });

            // Update background image on accordion collapse (Mobile)
            $('.accordion-button').on('shown.bs.collapse', function(e) {
                const category = $(e.target).data('category');
                console.log("Accordion expanded for:", category);
                updateImage(category);
            });
        });
    </script>
</body>
</html>