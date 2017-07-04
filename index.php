<!DOCTYPE html>
<html lang="en">
<head>
	<title>InsertInto</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="insertinto.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid text-center">
	<div class="row content">
		<div class="col-sm-offset-2 col-sm-8 text-left">
			<h1>InsertInto</h1>

			<p>I often found the need to take a list of IDs and merge them one by one into a command that I wanted to run on the command line, in SQL, etc. I've done this forever using
			a spreadsheet and concatenating values. I've finally decided to make an easier tool for doing this.  So, here you go.</p>

			<div class="row content">
				<div class="col-md-offset-1 col-xs-12 col-md-3">
					<label>List of values to insert:</label><br />
					<textarea id="list_of_values" cols="40" rows="15" style="text-align:left;"></textarea>
				</div>
				<div class="col-xs-12 col-md-offset-1 col-md-6 text-left">
					<label>String into insert value into:</label><br />
					<input type="text" style="width:100%;" id="string_to_insert_into" />
                    <p>Place <strong>{insert}</strong> into the string above to indicate where you'd like the values inserted into.</p>

                    <div style="padding-top:20px;padding-bottom: 20px;">
                        <input type="checkbox" id="sql_sanitize" value="1" /> <label for="sql_sanitize">Escape Values for SQL statement</label>
                    </div>

					<div>
						<button id="insert-button" class="btn btn-success">Insert Values!</button>
                        <button id="clear-button" class="btn btn-secondary">Clear All Values</button>
					</div>
				</div>
			</div>
			<div style="clear:both;" class="row content">
				<div clas="col-xs-12">
					<label for="output">Output:</label>
					<textarea id="output" style="width:100%;height:250px;"></textarea>
				</div>
			</div>

		</div>
		<div class="col-sm-2 sidenav">
			<div class="well">
				<p>ADS</p>
			</div>
			<div class="well">
				<p>ADS</p>
			</div>
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
	<p>Developed by <a href="https://www.shawnhooper.ca/">Shawn Hooper</a> - Contribute on GitHub: <a target="_blank" href="https://github.com/shawnhooper/insertinto">https://github.com/shawnhooper/insertinto</a></p>
</footer>

<script type="text/javascript">

	jQuery(document).ready(function() {

	    jQuery("#clear-button").click(function() {
            jQuery("#string_to_insert_into").val('');
            jQuery("#list_of_values").val('');
            jQuery("#output").empty();
        });

	    jQuery("#insert-button").click(function(e) {

	        // Is the {insert} placeholder there
            if ( jQuery("#string_to_insert_into").val().indexOf('{insert}') < 0 ) {
                alert('The {insert} placeholder is missing from the "String to Insert Value Into" box.');
                return false;
            }

            // Are we doing SQL sanitization
            var sqlSanitize = jQuery("#sql_sanitize").is(":checked");

            jQuery("#output").empty();
            var ks = jQuery('#list_of_values').val().split("\n");
            jQuery.each(ks, function(k){

                var insertThis = ks[k];

                if (sqlSanitize) {
                    insertThis = mysql_real_escape_string( insertThis );
                }
                console.log(insertThis);
                jQuery("#output").append( jQuery("#string_to_insert_into").val().replace('{insert}', insertThis ) + "\n" );

            });


        });

	});

	// Thanks Paul! https://stackoverflow.com/questions/7744912/making-a-javascript-string-sql-friendly
    function mysql_real_escape_string (str) {
        return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {
            switch (char) {
                case "\0":
                    return "\\0";
                case "\x08":
                    return "\\b";
                case "\x09":
                    return "\\t";
                case "\x1a":
                    return "\\z";
                case "\n":
                    return "\\n";
                case "\r":
                    return "\\r";
                case "\"":
                case "'":
                case "\\":
                case "%":
                    return "\\"+char; // prepends a backslash to backslash, percent,
                                      // and double/single quotes
            }
        });
    }

</script>

</body>
</html>
