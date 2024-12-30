<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .job-list {
            list-style: none;
            padding: 0;
        }
        .job-list li {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .job-list li:hover {
            background-color: #f9f9f9;
        }
        .job-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .job-description {
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        .job-details {
            font-size: 0.9em;
            color: #555;
        }
        .job-link {
            text-decoration: none;
            color: #007BFF;
        }
        .job-link:hover {
            text-decoration: underline;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            padding: 10px;
            margin: 0 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
        .section-title {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }
        .search-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 10px;
            width: 60%;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        .clear-button {
            background-color: #6c757d;
        }
        .clear-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<header>
    <h1>Job Board</h1>
</header>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container">
    <!-- Job Offers Section -->
    <section>
        <div class="section-title">Job Offers</div>

        <!-- Search Form -->
        <form class="search-form" method="GET" action="{{ url()->current() }}">
            <input type="text" name="search" placeholder="Search for job offers..." value="{{ request('search') }}">
            <button type="submit">Search</button>
            <a href="{{ url()->current() }}" class="clear-button" style="text-decoration: none; padding: 10px 20px; background-color: #6c757d; color: white; border-radius: 5px;">Clear Search</a>
        </form>

        <ul class="job-list">
            @foreach($jobOffers as $offer)
                <li>
                    <h3 class="job-title">{{ $offer->title }}</h3>
                    <p class="job-description">{{ $offer->description }}</p>
                    <p class="job-details"><strong>Posted by:</strong> {{ $offer->publisher->email }}</p>
                    <p class="job-details"><strong>Created at:</strong> {{ $offer->created_at->format('Y-m-d') }}</p>
                </li>
            @endforeach
        </ul>
        <!-- Pagination for Job Offers -->
        <div class="pagination">
            {{ $jobOffers->appends(['search' => request('search')])->links() }}
        </div>
    </section>

    <!-- External Job Offers Section -->
    <section>
        <div class="section-title">External Job Offers</div>
        <ul>
            @foreach($externalJobOffers as $offer)
                <li>
                    <h3>{{ $offer['name'] }}</h3>
                    <p>{{ $offer['office'] }}</p>
                    <p>{{ $offer['employmentType'] }}</p>
                    <p>{{ $offer['seniority'] }}</p>
                    <p><strong> {{ $offer['keywords'] }}</strong></p>
                    <p>{{ $offer['jobDescriptions'][0]['value'] }}</p> <!-- Example for first job description -->
                    <a href="https://mrge-group-gmbh.jobs.personio.de/job/{{ $offer['id'] }}">View Job</a>
                    <br>
                    <br>
                </li>
            @endforeach
        </ul>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
