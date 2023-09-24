<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SongModel;
use App\Models\PlaylistSongModel;
use App\Models\PlaylistModel;

class SongController extends BaseController
{
  // public function index()
  // {
  //   $songModel = new SongModel();
  //   $data['musicNames'] = $songModel->findAll();
  //
  //   return view('index', $data);
  // }


  public function store_song()
  {
      // Handle the form submission and audio insertion here
      if ($this->request->getMethod() === 'post' && $this->validate([
          'songName' => 'required',
          'songFile' => 'uploaded[songFile]|mime_in[songFile,audio/mpeg]' // Remove max_size rule
      ])) {
          $songName = $this->request->getPost('songName');
          $songFile = $this->request->getFile('songFile');
          $playlistID = $this->request->getPost('playlist'); // Get selected playlist ID

          // Move the uploaded audio file to a folder (e.g., public/uploads)
          if ($songFile->isValid() && !$songFile->hasMoved()) {
              $newName = $songFile->getRandomName();
              $songFile->move(ROOTPATH . 'public\uploads', $newName);

              // Get the path of the uploaded file
              $filePath = 'public/uploads/' . $newName;

              $songModel = new SongModel();
              $data = [
                  'Title' => $songName, // Map 'songName' to 'Title' column
                  'Source' => $filePath, // Store the file path in 'Source' column
              ];

              $songModel->insert($data);

              // Redirect or return a response as needed
              return redirect()->to('playlist'); // Redirect to a success page
          }
      }
  }



  public function addToPlaylist()
  {
      // Handle the form submission and add the song to the selected playlist here
      if ($this->request->getMethod() === 'post' && $this->validate([
          'playlist' => 'required|numeric', // Ensure the playlist ID is provided and numeric
          'songID' => 'required|numeric', // Ensure the song ID is provided and numeric
      ])) {
          $playlistID = $this->request->getPost('playlist');
          $songID = $this->request->getPost('songID');

          // Insert the song into the PlaylistSongs table
          $playlistSongModel = new PlaylistSongModel();
          $data = [
              'PlaylistID' => $playlistID,
              'SongID' => $songID,
          ];

          $playlistSongModel->insert($data);

          // Redirect or return a response as needed
          return redirect()->to('playlist'); // Redirect to a success page or playlist page
      }
  }



}
