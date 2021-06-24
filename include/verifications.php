<?php
require 'lib/WP_Incluyeme.php';
header('Content-type: application/json');
$result = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && !empty($_POST['id'])) {
    $data = new WP_Incluyeme();
    $data::setUserId($_POST['id']);
    if (count($_POST) == 1) {
        try {
            $result = $data->searchModifiedIncluyeme(true);
            echo json_response(200, $result);
        } catch (Exception $e) {
            echo json_response(500, 'Ha ocurrido un error');
        }
        return;
    }
    if (isset($_POST['read']) && $_POST['read'] === 'true') {
        $data::changeStatus($_POST['resume'], $_POST['statusChange'], $_POST['jobs'] ? $_POST['jobs'] : false);
        echo json_response(200, 'All Ok');
        return;
    }
    if (isset($_POST['favoritos'])) {
        $data::setFavs(true);
    }
    if (!empty($_POST['val']) && !empty($_POST['resume']) && !empty($_POST['changes'])) {
        $data::changeFavPub($_POST['val'], $_POST['resume']);
        echo json_response(200, 'All Ok');
        return;
    }
    if (count($_POST['status']) !== 0 && is_array($_POST['status'])) {
        $data::setStatus($_POST['status']);
    }
    if (count($_POST['course'])) {
        $data::setCourse($_POST['course']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setCourse($_POST['keyPhrase']);
        }
    }
    if (count($_POST['education'])) {
        $data::setEducation($_POST['education']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setEducation($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['resultsNumbers'])) {
        $data->resultsNumbers = $_POST['resultsNumbers'] === 0 ? 1 : $_POST['resultsNumbers'];
    } else {
        $data->resultsNumbers = 1;
    }
    if (!empty($_POST['city'])) {
        $data::setCity($_POST['city']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setCity($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['idioms'])) {
        $data::setIdioms($_POST['idioms']);
    }
    if (!empty($_POST['description'])) {
        $data::setDescription($_POST['description']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setDescription($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['jobs'])) {
        $data::setJob($_POST['jobs']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setJob($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['course'])) {
        $data::setCourse($_POST['course']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setCourse($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['name'])) {
        $data::setName($_POST['name']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setName($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['lastName'])) {
        $data::setLastName($_POST['lastName']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setLastName($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['education'])) {
        $data::setEducation($_POST['education']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setEducation($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['email'])) {
        $data::setEmail($_POST['email']);
    }
    if (!empty($_POST['description'])) {
        $data::setDescription($_POST['description']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setDescription($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['residence'])) {
        $data::setResidence($_POST['residence']);
    } else {
        if (!empty($_POST['keyPhrase'])) {
            $data::setResidence($_POST['keyPhrase']);
        }
    }
    if (!empty($_POST['keyPhrase'])) {
        $data::setSearchPhrase($_POST['keyPhrase']);
    }
    if (!empty($_POST['letter'])) {
        $data::setEscrito($_POST['letter']);
    }
    if (!empty($_POST['oral'])) {
        $data::setOral($_POST['oral']);
    }
    if (!empty($_POST['estudiosCheck'])) {
        $data::setEstudiosCheck($_POST['estudiosCheck']);
    }
    if (!empty($_POST['estudiosCheckF'])) {
        $data::setEstudiosCheckF($_POST['estudiosCheckF']);
    }
    if (!empty($_POST['idiomsN'])) {
        $data::setnewIdioms($_POST['idiomsN']);
    }
    if (count($_POST['selects']) !== 0 && is_array($_POST['selects'])) {
        $data::setDisability($_POST['selects']);
    }
    try {
        $result = $data->searchModifiedIncluyeme(true);
        echo json_response(200, $result);
    } catch (Exception $e) {
        echo json_response(500, 'Ha ocurrido un error');
    }
    return;
}

function json_response($code = 200, $message = null)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = [
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    ];
    // ok, validation error, or failure
    header('Status: ' . $status[$code]);
    
    // return the encoded json
    return json_encode([
        'status' => $code < 300, // success or not?
        'message' => $message
    ]);
}

$result = ["estado" => "false"];
echo json_response(500, 'Server Error! Please Try Again!');
return;
