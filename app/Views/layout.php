<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            min-width: 220px;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar a {
            display: block;
            color: #adb5bd;
            text-decoration: none;
            margin: 10px 0;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        .sidebar a.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            width: 100%;
            transition: all 0.3s;
        }

        /* Responsive for smaller screens */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mb-4">Admin Panel</h4>
        <a href="/levels" class="<?= uri_string() == 'levels' ? 'active' : '' ?>">Levels</a>
        <a href="/agents" class="<?= uri_string() == 'agents' ? 'active' : '' ?>">Agents</a>
    </div>

    <!-- Main content -->
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        <?php if(session()->getFlashdata('success')): ?>
        toastr.success("<?= session()->getFlashdata('success') ?>");
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
        toastr.error("<?= session()->getFlashdata('error') ?>");
        <?php endif; ?>
    </script>
</body>

</html>
