<script src="https://apis.google.com/js/api.js"></script>
<script>
    /**
     * Sample JavaScript code for analyticsadmin.accountSummaries.list
     * See instructions for running APIs Explorer code samples locally:
     * https://developers.google.com/explorer-help/code-samples#javascript
     */

    function authenticate() {
        return gapi.auth2.getAuthInstance()
            .signIn({
                scope: "https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly"
            })
            .then(function() {
                    console.log("Sign-in successful");
                },
                function(err) {
                    console.error("Error signing in", err);
                });
    }

    function loadClient() {
        gapi.client.setApiKey("AIzaSyDea7kxYVW-MKM4yM8LFkaXo9tPSAlq2Ng");
        return gapi.client.load("https://analyticsadmin.googleapis.com/$discovery/rest?version=v1beta")
            .then(function() {
                    console.log("GAPI client loaded for API 1");
                },
                function(err) {
                    console.error("Error loading GAPI client for API 1", err);
                });
    }

    function loadClient2() {
        gapi.client.setApiKey("AIzaSyDea7kxYVW-MKM4yM8LFkaXo9tPSAlq2Ng");
        return gapi.client.load("https://analyticsdata.googleapis.com/$discovery/rest?version=v1beta")
            .then(function() {
                    execute()
                    console.log("GAPI client loaded for API 2");
                },
                function(err) {
                    console.error("Error loading GAPI client for API 2", err);
                });
    }
    // Make sure the client is loaded and sign-in is complete before calling this method.
    function execute() {
        return gapi.client.analyticsadmin.accountSummaries.list({})
            .then(function(response) {
                    // Handle the results here (response.result has the parsed body).
                    var GA_Data = response.result.accountSummaries;
                    var name = document.getElementById("displayName");
                    name.innerHTML = "<option value=''>Select Name</option>";
                    for (let i = 0; i < GA_Data.length; i++) {
                        name.insertAdjacentHTML('beforeend', "<option value='" + GA_Data[i].propertySummaries[0].property + "'>" + GA_Data[i].displayName + "</option>");
                    }
                    console.log("Response", response.result.accountSummaries);
                },
                function(err) {
                    console.error("Execute error", err);
                });
    }
    // Get data
    function getData() {
        var property = document.getElementById("displayName").value;
        return gapi.client.analyticsdata.properties.runReport({
                "property": property,
                "resource": {
                    "metrics": [{
                        "name": "active28DayUsers"
                    }],
                    "dateRanges": [{
                        "startDate": "30daysAgo",
                        "endDate": "today"
                    }]
                }
            })
            .then(function(response) {
                    // Handle the results here (response.result has the parsed body).
                    console.log("Response", response);
                },
                function(err) {
                    console.error("Execute error", err);
                });
    }
    gapi.load("client:auth2", function() {
        gapi.auth2.init({
            client_id: "507945039016-np0d2k9pv55ak977hnki91rojorm9p4r.apps.googleusercontent.com",
            plugin_name: 'hello'
        });
    });
</script>
<button onclick="authenticate().then(loadClient).then(loadClient2)">authorize and load</button>
<!-- <button onclick="execute()">execute</button> -->
<br>
<br>
<select id="displayName">
    <option value="">Select Name</option>
</select>
<br>
<br>
<button onclick="getData()">Get data from Google Analytics</button>