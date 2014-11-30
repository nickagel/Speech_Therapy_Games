<script>
    var memory_array = <?php echo json_encode($soundArray); ?>;
    var memory_values = [];
    var memory_tile_ids = [];
    var tiles_flipped = 0;
    Array.prototype.memory_tile_shuffle = function () {
        var i = this.length, j, temp;
        while (--i > 0) {
            j = Math.floor(Math.random() * (i + 1));
            temp = this[j];
            this[j] = this[i];
            this[i] = temp;
        }
    }
    function newBoard() {
        tiles_flipped = 0;
        var output = '';
        var audio ='';
        memory_array.memory_tile_shuffle();
        var w = 0;
        output +="<table>";
        for (var i = 0; i < memory_array.length; i++) {
            if (w==4){
                w=0;
            }
            if (w == 0) {
                output += '<tr>';
            }
            output += '<td id="tile_' + i + '" onclick="memoryFlipTile(this,\'' + (memory_array[i])[1] + '\'); play(\''+(memory_array[i])[0]+'\');"></td>';
            audio += '<audio id="'+ (memory_array[i])[0] + '" src="audio/'+(memory_array[i])[0]+'.mp3" ></audio>';

            if (w == 4) {
                output += '</tr>';
            }
            w++;
        }
        output +="</table>";
        output += audio;
        document.getElementById('memory_board').innerHTML = output;
    }
    function play(name){
       var audio = document.getElementById(name);
       audio.play();
                 }
    function memoryFlipTile(tile, val) {
        if (tile.innerHTML == "" && memory_values.length < 2) {
            tile.style.background = '#FFF';
            tile.innerHTML = '<img alt="match pic" class="matchImg" src="' + val + '"> ';
            if (memory_values.length == 0) {
                memory_values.push(val);
                memory_tile_ids.push(tile.id);
            } else if (memory_values.length == 1) {
                memory_values.push(val);
                memory_tile_ids.push(tile.id);
                if (memory_values[0] == memory_values[1]) {
                    tiles_flipped += 2;
                    // Clear both arrays
                    memory_values = [];
                    memory_tile_ids = [];
                    // Check to see if the whole board is cleared
                    if (tiles_flipped == memory_array.length) {
                        alert("Board cleared... generating new board");
                        document.getElementById('memory_board').innerHTML = "";
                        newBoard();
                    }
                } else {
                    function flip2Back() {
                        // Flip the 2 tiles back over
                        var tile_1 = document.getElementById(memory_tile_ids[0]);
                        var tile_2 = document.getElementById(memory_tile_ids[1]);
                        tile_1.style.background = 'url(tile_bg.jpg) no-repeat';
                        tile_1.innerHTML = "";
                        tile_2.style.background = 'url(tile_bg.jpg) no-repeat';
                        tile_2.innerHTML = "";
                        // Clear both arrays
                        memory_values = [];
                        memory_tile_ids = [];
                    }
                    setTimeout(flip2Back, 4500);
                }
            }
        }
    }
</script>