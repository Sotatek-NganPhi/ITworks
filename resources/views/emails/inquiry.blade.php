<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Mail inquiry</h2>
        <div>
            <p><b>Company name:</b> {{ $inquiry["company_name"] }}</p>
            <p><b>Name:</b> {{ $inquiry["name_person"] }}</p>
            <p><b>Job category:</b> {{ $inquiry["job_category"] }}</p>
            <p><b>Postal code:</b> {{ $inquiry["postal_code"] }}</p>
            <p><b>Address:</b> {{ $inquiry["address"] }}</p>
            <p><b>Inquiry phone number:</b> {{ $inquiry["contact_phone_number"] }}</p>
            <p><b>Inquiry email:</b> {{ $inquiry["contact_email_address"] }}</p>
            <p><b>Content of inquiry:</b> {{ $inquiry["content_inquiry"] }}</p>
            <p><b>Where did you learn about this site ?:</b> {{ $inquiry["desire"]}}</p>
        </div>
    </body>
</html>