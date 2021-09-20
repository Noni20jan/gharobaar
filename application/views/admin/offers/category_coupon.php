<!DOCTYPE html>
<html>

<head>

    <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="treeview-checkbox-demo">
                    <ul>
                        <li>HTML
                            <ul>
                                <li data-value="table">HTML table</li>
                                <li data-value="links">HTML links</li>
                            </ul>
                        </li>
                        <li>PHP
                            <ul>
                                <li data-value="PHP if..else">PHP if..else</li>
                                <li>PHP Loops
                                    <ul>
                                        <li data-value="For loop">For loop</li>
                                        <li data-value="While loop">While loop</li>
                                        <li data-value="Do WHile loop">Do WHile loop</li>
                                    </ul>
                                </li>
                                <li>PHP arrays</li>
                            </ul>
                        </li>
                        <li>jQuery
                            <ul>
                                <li data-value="jQuery append">jQuery append</li>
                                <li data-value="jQuery prepend">jQuery prepend</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn btn-success" id="show-values">Get Values</button>
                <pre id="values"></pre>
            </div>
        </div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/jquery-treeview/logger.js"></script>
    <script src="js/jquery-treeview/treeview.js"></script>

    <script>
        $('#treeview-checkbox-demo').treeview({
            debug: true,
            data: ['links', 'Do WHile loop']
        });
        $('#show-values').on('click', function() {
            $('#values').text(
                $('#treeview-checkbox-demo').treeview('selectedValues')
            );
        });
    </script>
</body>

</html>