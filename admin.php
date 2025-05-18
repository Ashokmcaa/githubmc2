<?php
include 'config.php';

// Create table if not exists
$conn->exec("CREATE TABLE IF NOT EXISTS content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255),
    title VARCHAR(255),
    subtitle VARCHAR(255),
    description TEXT,
    image_path VARCHAR(255),
    svg_path VARCHAR(255)
)");

// Sample data insertion (run only once)


// Ensure uploads directory exists
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// CRUD Operations
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'create') {
    $category = $_POST['category'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $imageExt;
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $svgPath = '';
    if (isset($_FILES['svg']) && $_FILES['svg']['error'] == 0) {
        $svgExt = pathinfo($_FILES['svg']['name'], PATHINFO_EXTENSION);
        if (strtolower($svgExt) === 'svg') {
            $svgName = uniqid() . '.' . $svgExt;
            $svgPath = $uploadDir . $svgName;
            move_uploaded_file($_FILES['svg']['tmp_name'], $svgPath);
        }
    }

    $stmt = $conn->prepare("INSERT INTO content (category, title, subtitle, description, image_path, svg_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category, $title, $subtitle, $description, $imagePath, $svgPath]);
    echo json_encode(['status' => 'success']);
    exit;
}

if ($action == 'read') {
    $stmt = $conn->query("SELECT * FROM content");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

if ($action == 'update') {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];

    // Fetch existing paths
    $stmt = $conn->prepare("SELECT image_path, svg_path FROM content WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    $imagePath = $existing['image_path'];
    $svgPath = $existing['svg_path'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Delete old image if exists
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $imageExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $imageExt;
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    if (isset($_FILES['svg']) && $_FILES['svg']['error'] == 0) {
        $svgExt = pathinfo($_FILES['svg']['name'], PATHINFO_EXTENSION);
        if (strtolower($svgExt) === 'svg') {
            // Delete old SVG if exists
            if ($svgPath && file_exists($svgPath)) {
                unlink($svgPath);
            }
            $svgName = uniqid() . '.' . $svgExt;
            $svgPath = $uploadDir . $svgName;
            move_uploaded_file($_FILES['svg']['tmp_name'], $svgPath);
        }
    }

    $stmt = $conn->prepare("UPDATE content SET category=?, title=?, subtitle=?, description=?, image_path=?, svg_path=? WHERE id=?");
    $stmt->execute([$category, $title, $subtitle, $description, $imagePath, $svgPath, $id]);
    echo json_encode(['status' => 'success']);
    exit;
}

if ($action == 'delete') {
    $id = $_POST['id'];
    // Fetch paths to delete files
    $stmt = $conn->prepare("SELECT image_path, svg_path FROM content WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['image_path'] && file_exists($row['image_path'])) {
        unlink($row['image_path']);
    }
    if ($row['svg_path'] && file_exists($row['svg_path'])) {
        unlink($row['svg_path']);
    }

    $stmt = $conn->prepare("DELETE FROM content WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - DelphianLogic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }

        .form-section, .table-section {
            margin-bottom: 20px;
        }

        .form-section input, .form-section textarea {
            margin-bottom: 10px;
        }

        .preview-img, .preview-svg {
            max-width: 100px;
            max-height: 100px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin - Manage Content</h1>

        <!-- Create Form -->
        <div class="form-section">
            <h3>Add New Content</h3>
            <div id="createForm">
                <input type="text" id="createCategory" class="form-control" placeholder="Category" required>
                <input type="text" id="createTitle" class="form-control" placeholder="Title" required>
                <input type="text" id="createSubtitle" class="form-control" placeholder="Subtitle" required>
                <textarea id="createDescription" class="form-control" placeholder="Description" required></textarea>
                <label>Image Upload (JPEG, PNG, etc.)</label>
                <input type="file" id="createImage" class="form-control" accept="image/*" required>
                <label>SVG Upload</label>
                <input type="file" id="createSvg" class="form-control" accept=".svg" required>
                <button class="btn btn-primary" onclick="createContent()">Add Content</button>
            </div>
        </div>

        <!-- Update Form -->
        <div class="form-section">
            <h3>Update Content</h3>
            <div id="updateForm">
                <input type="hidden" id="updateId">
                <input type="text" id="updateCategory" class="form-control" placeholder="Category" required>
                <input type="text" id="updateTitle" class="form-control" placeholder="Title" required>
                <input type="text" id="updateSubtitle" class="form-control" placeholder="Subtitle" required>
                <textarea id="updateDescription" class="form-control" placeholder="Description" required></textarea>
                <label>Image Upload (JPEG, PNG, etc.)</label>
                <input type="file" id="updateImage" class="form-control" accept="image/*">
                <img id="updateImagePreview" class="preview-img" src="" alt="Image Preview" style="display: none;">
                <label>SVG Upload</label>
                <input type="file" id="updateSvg" class="form-control" accept=".svg">
                <img id="updateSvgPreview" class="preview-svg" src="" alt="SVG Preview" style="display: none;">
                <button class="btn btn-warning" onclick="updateContent()">Update Content</button>
            </div>
        </div>

        <!-- Content Table -->
        <div class="table-section">
            <h3>Content List</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Description</th>
                        <th>Image Path</th>
                        <th>SVG Path</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="contentTable">
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            loadContent();

            // Reset update form
            $('#updateForm input, #updateForm textarea').val('');
            $('#updateImagePreview, #updateSvgPreview').hide();
        });

        function loadContent() {
            $.ajax({
                url: 'admin.php',
                type: 'POST',
                data: { action: 'read' },
                dataType: 'json',
                success: function(data) {
                    const tableBody = $('#contentTable');
                    tableBody.empty();
                    data.forEach(item => {
                        tableBody.append(`
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.category}</td>
                                <td>${item.title}</td>
                                <td>${item.subtitle}</td>
                                <td>${item.description}</td>
                                <td><img src="${item.image_path}" alt="Image" style="max-width: 100px;"></td>
                                <td><img src="${item.svg_path}" alt="SVG" style="max-width: 100px;"></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editContent(${item.id}, '${item.category}', '${item.title}', '${item.subtitle}', '${item.description}', '${item.image_path}', '${item.svg_path}')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteContent(${item.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }

        function createContent() {
            const formData = new FormData();
            formData.append('action', 'create');
            formData.append('category', $('#createCategory').val());
            formData.append('title', $('#createTitle').val());
            formData.append('subtitle', $('#createSubtitle').val());
            formData.append('description', $('#createDescription').val());
            formData.append('image', $('#createImage')[0].files[0]);
            formData.append('svg', $('#createSvg')[0].files[0]);

            $.ajax({
                url: 'admin.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        loadContent();
                        $('#createForm input, #createForm textarea').val('');
                        $('#createImage, #createSvg').val('');
                        alert('Content added successfully!');
                    }
                }
            });
        }

        function editContent(id, category, title, subtitle, description, imagePath, svgPath) {
            $('#updateId').val(id);
            $('#updateCategory').val(category);
            $('#updateTitle').val(title);
            $('#updateSubtitle').val(subtitle);
            $('#updateDescription').val(description);
            if (imagePath) {
                $('#updateImagePreview').attr('src', imagePath).show();
            } else {
                $('#updateImagePreview').hide();
            }
            if (svgPath) {
                $('#updateSvgPreview').attr('src', svgPath).show();
            } else {
                $('#updateSvgPreview').hide();
            }
        }

        function updateContent() {
            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id', $('#updateId').val());
            formData.append('category', $('#updateCategory').val());
            formData.append('title', $('#updateTitle').val());
            formData.append('subtitle', $('#updateSubtitle').val());
            formData.append('description', $('#updateDescription').val());
            if ($('#updateImage')[0].files[0]) {
                formData.append('image', $('#updateImage')[0].files[0]);
            }
            if ($('#updateSvg')[0].files[0]) {
                formData.append('svg', $('#updateSvg')[0].files[0]);
            }

            $.ajax({
                url: 'admin.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        loadContent();
                        $('#updateForm input, #updateForm textarea').val('');
                        $('#updateImage, #updateSvg').val('');
                        $('#updateImagePreview, #updateSvgPreview').hide();
                        alert('Content updated successfully!');
                    }
                }
            });
        }

        function deleteContent(id) {
            if (confirm('Are you sure you want to delete this content?')) {
                $.ajax({
                    url: 'admin.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            loadContent();
                            alert('Content deleted successfully!');
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>