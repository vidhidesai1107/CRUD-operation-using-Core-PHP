<!DOCTYPE html>
<html>

<head>
    <title>Insert Candidate Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Insert Candidate's Record</h2>
                <form id="candidateForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>State:</label>
                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">Select State</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <select name="city_id" id="city_id" class="form-control">
                            <option value="">Select City</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Age:</label>
                        <input type="number" name="age" id="age" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Document:</label>
                        <input type="file" name="document" class="form-control-file">
                    </div>
                    <input type="hidden" id="candidateId" name="candidateId">
                    <input type="submit" value="Submit" class="btn btn-primary">
                </form>
            </div>
            <div class="col-md-6">
                <h2>Candidate List</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Age</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="candidateList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function fetchCandidates() {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_candidates.php',
                    success: function(data) {
                        $('#candidateList').html(data);
                    }
                });
            }

            // Fetch states and cities
            $.ajax({
                type: 'GET',
                url: 'get_states.php',
                success: function(html) {
                    $('#state_id').html(html);
                }
            });

            $.ajax({
                type: 'GET',
                url: 'get_cities.php',
                success: function(html) {
                    $('#city_id').html(html);
                }
            });

            fetchCandidates();

            // AJAX form submission
            $('#candidateForm').submit(function(e) {
                e.preventDefault();

                var name = $("input[name='name']").val();
                var stateId = $("#state_id").val();
                var cityId = $("#city_id").val();
                var age = $("#age").val();
                var documentFile = $("input[name='document']").val();
                var candidateId = $("#candidateId").val();

                if (name === '') {
                    alert("Name is required.");
                    return;
                }

                if (stateId === '') {
                    alert("State is required.");
                    return;
                }

                if (cityId === '') {
                    alert("City is required.");
                    return;
                }

                if (age === '') {
                    alert("Age is required.");
                    return;
                }

                if (isNaN(parseInt(age)) || parseInt(age) < 18) {
                    alert("Age must be a number and greater than or equal to 18.");
                    return;
                }

                if (documentFile === '') {
                    alert("Document is required.");
                    return;
                }

                var formData = new FormData(this);

                if (candidateId) { // Update operation
                    formData.append('id', candidateId);
                    $.ajax({
                        url: 'edit_candidate.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert("Candidate details updated successfully!");
                                fetchCandidates();
                            } else {
                                alert("Error updating candidate: " + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        }
                    });
                } else { // Insert operation
                    $.ajax({
                        url: 'sub.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            alert("Record Inserted Successfully!");
                            fetchCandidates();

                        }
                    });
                }
            });

            // Edit Candidate
            $(document).on('click', '.editCandidate', function() {
                var candidateId = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'edit_candidate.php',
                    data: {
                        id: candidateId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $("input[name='name']").val(response.name);
                            $("#state_id").val(response.state_id);
                            $("#city_id").val(response.city_id);
                            $("#age").val(response.age);
                            $("#candidateId").val(response.id);
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            });

            // Delete candidate
            $(document).on('click', '.deleteCandidate', function() {
                var candidateId = $(this).data('id');
                if (confirm("Are you sure you want to delete this candidate?")) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_candidate.php',
                        data: {
                            id: candidateId
                        },
                        success: function(response) {
                            alert("Candidate deleted successfully!");
                            fetchCandidates();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
