<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 sidebar">

                <h4>Admin Panel</h4>

                <a href="#">Dashboard</a>
                <a href="#">Tours</a>
                <a href="#">Bookings</a>
                <a href="#">Users</a>
                <a href="#">Payments</a>
                <a href="#">Reviews</a>
                <a href="#">Tour Guides</a>
                <a href="#">Partners</a>
                <a href="#">Logout</a>

            </div>


            <!-- Content -->
            <div class="col-md-10 p-4">

                <h3>Dashboard</h3>

                <div class="row mt-4">

                    <div class="col-md-3">
                        <div class="card p-3 text-center">
                            <h5>Total Tours</h5>
                            <h3>45</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 text-center">
                            <h5>Total Users</h5>
                            <h3>120</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 text-center">
                            <h5>Total Bookings</h5>
                            <h3>87</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 text-center">
                            <h5>Revenue</h5>
                            <h3>150M</h3>
                        </div>
                    </div>

                </div>


                <h4 class="mt-5">Recent Bookings</h4>

                <table class="table table-bordered mt-3">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Tour</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Nguyen Van A</td>
                            <td>Da Lat Tour</td>
                            <td>12-05-2026</td>
                            <td>Paid</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Tran Thi B</td>
                            <td>Phu Quoc Tour</td>
                            <td>15-05-2026</td>
                            <td>Pending</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</body>

</html>