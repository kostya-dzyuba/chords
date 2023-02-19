<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аккорды песни "<?php
        include 'db.php';
        $id = $_GET['id'];
        $stmt = $conn->prepare('select name, chords from songs where id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo $row['name'];
        ?>"
    </title>
    <link rel="stylesheet" href="style.css">
    <script>
        function f() {
            let chords = document.getElementById("chords");
            chords.innerText = transpose(chords.innerText);
        }

        function transpose(original) {
            let transposed = "";
            let chord = "";
            for (let i = 0; i < original.length; i++) {
                let c = original.charAt(i);
                if ((c >= 'A' && c <= 'G') || c === 'm' || c === '#') {
                    chord += c;
                } else if (chord) {
                    transposed += down(chord);
                    transposed += c;
                    chord = "";
                } else {
                    transposed += c;
                }
            }
            return transposed.toString();
        }

        function down(chord) {
            let tonic = chord[0]
            if (chord.length === 1) {
                if (tonic === 'C' || tonic === 'F') {
                    return String.fromCharCode(tonic.charCodeAt(0) - 1);
                } else {
                    if (tonic === 'A') {
                        return "G#";
                    } else {
                        return String.fromCharCode(tonic.charCodeAt(0) - 1) + "#";
                    }
                }
            } else if (chord.length === 2) {
                if (chord[1] === 'm') {
                    let mode = chord[1];
                    if (tonic === 'C' || tonic === 'F') {
                        return String.fromCharCode(tonic.charCodeAt(0) - 1) + mode;
                    } else {
                        if (tonic === 'A') {
                            return "G#" + mode;
                        } else {
                            return String.fromCharCode(tonic.charCodeAt(0) - 1) + "#" + mode;
                        }
                    }
                } else if (chord[1] === '#') {
                    return tonic;
                } else {
                    throw new Error(chord);
                }
            } else if (chord.length === 3) {
                return tonic + chord[2];
            } else {
                throw new Error(chord);
            }
        }
    </script>
</head>
<body>
<h1><a href="/">Аккорды</a></h1>
<button style="position: absolute; right: 0; margin-right: 100px" onclick="f()">Транспонировать</button>
<div><pre id="chords">
<?php
$stmt = $conn->prepare('update songs set views = views + 1 where id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
echo $row['chords'];
?>
</pre></div>
</body>
</html>
