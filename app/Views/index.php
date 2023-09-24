<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
         font-family: Arial, sans-serif;
         text-align: center;
         background-color: #f5f5f5;
         padding: 20px;
     }

     h1 {
         color: #333;
     }

     #player-container {
         max-width: 400px;
         margin: 0 auto;
         padding: 20px;
         background-color: #fff;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
     }

     audio {
         width: 100%;
     }

     #playlist {
         list-style: none;
         padding: 0;
     }

     #playlist li {
         cursor: pointer;
         padding: 10px;
         background-color: #eee;
         margin: 5px 0;
         transition: background-color 0.2s ease-in-out;
     }

     #playlist li:hover {
         background-color: #ddd;
     }

     #playlist li.active {
         background-color: #007bff;
         color: #fff;
     }
    </style>
</head>
<body>


  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul>
              <?php foreach ($playlists as $playlist): ?>
                  <li>
                      <a href="#" class="playlist-link" data-playlist-id="<?php echo $playlist['PlaylistID']; ?>">
                          <?php echo $playlist['Name']; ?>
                      </a>
                  </li>
              <?php endforeach; ?>
          </ul>


        </div>
        <div class="modal-footer">
          <a href="#" data-bs-dismiss="modal">Close</a>
          <a href="#" data-bs-toggle="modal" data-bs-target="#createPlaylist">Create New</a>

        </div>
      </div>
    </div>
  </div>

  <!-- modal create -->

  <div class="modal fade" id="createPlaylist" tabindex="-1" aria-labelledby="createPlaylistLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createPlaylistLabel">Create New Playlist</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Create a form for adding a new playlist -->
          <form action="/playlist/store" method="post">
            <div class="mb-3">
              <label for="Name" class="form-label">Playlist Name</label>
              <input type="text" class="form-control" id="Name" name="Name" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="createPlaylistButton">Add Playlist</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>



  <form action="/" method="get">
      <input type="search" name="search" id="searchInput" placeholder="Search for a song">
      <button type="submit" class="btn btn-primary">Search</button>
  </form>


    <h1>Music Player</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      My Playlist
    </button>

    <audio id="audio" controls autoplay></audio>

<!-- adding of song -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSongModal">
      Add Song
    </button>

    <div class="modal fade" id="addSongModal" tabindex="-1" aria-labelledby="addSongModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSongModalLabel">Add New Song</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <!-- Create a form for adding a new song with file upload -->
          <form action="/song/store" method="post" enctype="multipart/form-data">
              <div class="mb-3">
                  <label for="songName" class="form-label">Song Name</label>
                  <input type="text" class="form-control" id="songName" name="songName" required>
              </div>
              <div class="mb-3">
                  <label for="songFile" class="form-label">Song File</label>
                  <input type="file" class="form-control" id="songFile" name="songFile" accept=".mp3" required>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add Song</button>
              </div>
          </form>
      </div>

    </div>
  </div>
</div>


<!--  -->

<ul id="playlist">
    <?php foreach ($musicNames as $music): ?>
        <li data-src="<?= base_url('public/uploads/' . $music['Source']); ?>">
            <?= $music['Title']; ?>
            <button class="btn btn-primary add-to-playlist-button" data-song-id="<?= $music['SongID']; ?>">
                +
            </button>
        </li>
    <?php endforeach; ?>
</ul>

<div class="modal fade" id="addToPlaylistModal" tabindex="-1" aria-labelledby="addToPlaylistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToPlaylistModalLabel">Add to Playlist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/song/store/playlist" method="post">
                    <input type="hidden" id="songID" name="songID">
                    <div class="mb-3">
                        <label for="playlistSelect" class="form-label">Select Playlist</label>
                        <select class="form-control" id="playlistSelect" name="playlist" required>
                            <?php foreach ($playlists as $playlist): ?>
                                <option value="<?php echo $playlist['PlaylistID']; ?>"><?php echo $playlist['Name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Song to Playlist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  -->


    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Select from playlist</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
          <form action="/" method="post">
            <!-- <p id="modalData"></p> -->
            <input type="hidden" id="musicID" name="musicID">
            <select  name="playlist" class="form-control" >

              <option value="playlist">playlist</option>

            </select>
            <input type="submit" name="add">
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

<script>

<script>
$(document).ready(function () {
    // Event listener for playlist links
    $(".playlist-link").click(function (event) {
        event.preventDefault(); // Prevent the default link behavior

        const playlistId = $(this).data("playlist-id");

        // Call a function to load and display songs for the selected playlist
        loadAndDisplaySongs(playlistId);
    });

    // Function to load and display songs for the selected playlist
    function loadAndDisplaySongs(playlistId) {
        // Make an AJAX request to fetch songs for the selected playlist
        $.ajax({
            url: "/playlist/display/" + playlistId, // Replace with your actual endpoint
            method: "GET",
            success: function (data) {
                // Assuming data is an array of song objects
                // Update the playlist view with the songs
                updatePlaylistView(data);
            },
            error: function (error) {
                console.error("Error loading songs for playlist:", error);
            },
        });
    }

    // Function to update the playlist view with songs
    function updatePlaylistView(songs) {
        const playlist = $("#playlist");
        playlist.empty();

        songs.forEach(function (song) {
            const listItem = $("<li>");
            listItem.text(song.Title);
            listItem.attr("data-src", song.Source);
            playlist.append(listItem);
        });
    }
});
</script>
</script>

    <script>
    $(document).ready(function () {
      // Get references to the button and modal
      const modal = $("#myModal");
      const modalData = $("#modalData");
      const musicID = $("#musicID");
      // Function to open the modal with the specified data
      function openModalWithData(dataId) {
        // Set the data inside the modal content
        modalData.text("Data ID: " + dataId);
        musicID.val(dataId);
        // Display the modal
        modal.css("display", "block");
      }

      // Add click event listeners to all open modal buttons

      // When the user clicks the close button or outside the modal, close it
      modal.click(function (event) {
        if (event.target === modal[0] || $(event.target).hasClass("close")) {
          modal.css("display", "none");
        }
      });
    });

    //
    // JavaScript code for handling the "Add to Playlist" button clicks
    $(document).ready(function () {
        // Get references to the modal and button
        const playlistModal = $("#addToPlaylistModal");
        const addToPlaylistButtons = document.querySelectorAll(".add-to-playlist-button");

        // Function to open the modal with the specified song ID
        function openPlaylistModal(songID) {
            // Set the song ID in the modal
            playlistModal.find("#songID").val(songID);
            // Display the modal
            playlistModal.modal("show");
        }

        // Add click event listeners to all "Add to Playlist" buttons
        addToPlaylistButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const songID = button.getAttribute("data-song-id");
                openPlaylistModal(songID);
            });
        });

        // When the user clicks the close button or outside the modal, close it
        playlistModal.on("hidden.bs.modal", function () {
            playlistModal.find("#songID").val(""); // Clear the song ID when modal is hidden
        });
    });

    //


    // modal create new
    $("#createPlaylistButton").click(function () {
    $("#createPlaylist").modal("show");
    });
    </script>
    <script>
    const audio = document.getElementById('audio');
    const playlist = document.getElementById('playlist');
    const playlistItems = playlist.querySelectorAll('li');
    let currentTrack = 0;

    function playTrack(trackIndex) {
        if (trackIndex >= 0 && trackIndex < playlistItems.length) {
            const track = playlistItems[trackIndex];
            const trackSrc = track.getAttribute('data-src');

            // Log the source URL for debugging
            console.log('Attempting to play:', trackSrc);

            audio.src = trackSrc; // Set the absolute URL or correct relative path

            // Add an event listener for error handling
            audio.addEventListener('error', (error) => {
                console.error('Error loading audio:', error);
            });

            audio.play()
                .then(() => {
                    console.log('Audio playback started successfully.');
                })
                .catch((error) => {
                    console.error('Error playing audio:', error);
                });

            currentTrack = trackIndex;

            // Highlight the active track in the playlist
            playlistItems.forEach((item, index) => {
                if (index === currentTrack) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }
    }

    playlistItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            playTrack(index);
        });
    });

    audio.addEventListener('ended', () => {
        currentTrack = (currentTrack + 1) % playlistItems.length;
        playTrack(currentTrack);
    });

    // Add a play button click event to initiate playback
    const playButton = document.getElementById('playButton');
    playButton.addEventListener('click', () => {
        playTrack(currentTrack);
    });


    function nextTrack() {
        currentTrack = (currentTrack + 1) % playlistItems.length;
        playTrack(currentTrack);
    }

    function previousTrack() {
        currentTrack = (currentTrack - 1 + playlistItems.length) % playlistItems.length;
        playTrack(currentTrack);
    }

    playlistItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            playTrack(index);
        });
    });

    audio.addEventListener('ended', () => {
        nextTrack();
    });

    playTrack(currentTrack);

    //
    $(document).ready(function () {
            // Event listener for playlist links
            $(".playlist-link").click(function (event) {
                event.preventDefault(); // Prevent the default link behavior

                const playlistId = $(this).data("playlist-id");

                // Call a function to load and display songs for the selected playlist
                loadAndDisplaySongs(playlistId);
            });

            // Function to load and display songs for the selected playlist
            function loadAndDisplaySongs(playlistId) {
                // Make an AJAX request to fetch songs for the selected playlist
                $.ajax({
                    url: "/playlist/display/" + playlistId, // Replace with your actual endpoint
                    method: "GET",
                    success: function (data) {
                        // Assuming data is an array of song objects
                        // Update the playlist view with the songs
                        updatePlaylistView(data);
                    },
                    error: function (error) {
                        console.error("Error loading songs for playlist:", error);
                    },
                });
            }

            // Function to update the playlist view with songs
            function updatePlaylistView(songs) {
                const playlist = $("#playlist");
                playlist.empty();

                songs.forEach(function (song) {
                    const listItem = $("<li>");
                    listItem.text(song.Title);
                    listItem.attr("data-src", song.Source);
                    playlist.append(listItem);
                });
            }
        });

    //
</script>

</body>
</html>
