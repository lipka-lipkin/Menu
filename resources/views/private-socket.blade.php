<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>WebSockets Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
</head>

<body>

<script>
    var app = {
        'key' : 'key',
        'host' : '127.0.0.1',
        'wsPort' : '6001',
        'authEndpoint' : ' broadcasting/auth',
        'token' : 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDUyYmJiZjM2NmRmMTM4ZmI0NGQ5YjViMGVlM2E4ZDc3MzBlYzg4Nzk0NjAxZGViZGU0ZmU4NjBkZTlhZWUzY2RhM2ZkM2FhZjFlYzIwNjYiLCJpYXQiOjE1ODM4NTM0NjQsIm5iZiI6MTU4Mzg1MzQ2NCwiZXhwIjoxNjE1Mzg5NDY0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.ptwO_1GyCLF780BHlEGRAArsavd3-xRzz-br9aesS6f3KfImo2S2fkZACVHSsYbMwNaI04Dj0liFScdSay53yB5XatX81W275fV-aNHiQ1cG8LrHbihu1n6l_glQQO9y7bqoApAbphPqxSYJ39KzIRgJ13kBs4la3ggxpdDSVdwYkBYzbWuUc30N10V3hs2J2m9UCrtCdVcfm5pLaJ3OVfrraMxon6tWChoS5qrq3G4Fc88SyXePYNGfi53zIkWoxT-jCWR2NiN2cM2ugIt6i4Hudu_0ZJgFhJHs1UtCyZvlqx-sVUc0veT4S6hMA05IxJAEfMKMgRAfFfmHDIdRy9DrqyCjrRM-bkh85ouL6pBP6jvivn_XcwOdySVtY8pDRXPwxy3z4Mo928dYJE9tHm2uxs9ymsqy_yZEeR6hclnMaWlUETGzS-C1febsThz9tIQiKx7UPktHNvsy_SGu26SAYgIYODp7UN-lj_WayKV1_pZtLh-IV-Sx9BHryFz9Uc29fOCFgDKEhOb-7J7_C9MGHSXZeWWwZNQRrBkXPU4rWFOWYE9Kmfmdr3uoAVDGpazYnzRgL52pggcKdWTnQMtYox9ZiCSfldN_meSNWmiH_eBhtgMjJO0qOoxC5332QPYwS1Oki1g4uca24VItwh0mb_UtEIlv6UrZSH6Ewdc'
    };

    var pusher = new Pusher(this.app.key, {
        wsHost: app.host,
        wsPort: app.wsPort,
        disableStats: true,
        authEndpoint: app.authEndpoint,
        auth: {
            headers: {
                'Authorization' : 'Bearer ' + app.token,
            }
        },
        enabledTransports: ['ws', 'flash']
    });
    pusher.connection.bind('connected', () => {
        console.log('connected');
        pusher.subscribe('private-user.1')
            .bind('App\\Events\\UserPush', (data) => {
                console.log(data);
            });
    });
</script>

</body>
</html>
