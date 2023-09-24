<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PlaylistModel;
use App\Models\SongModel;

class PlaylistController extends BaseController
{
    public function index()
    {
      // retreive playlist in modal
      $playlistModel = new PlaylistModel();
      $data['playlists'] = $playlistModel->findAll();

      //retrieve songs in index
      $songModel = new SongModel();
      $data['musicNames'] = $songModel->findAll();

      return view('index', $data);
    }

    public function store_pl()
    {
      $playlistModel = new PlaylistModel();
      $data = [
        'Name' => $this->request->getPost('Name'),
      ];

      $playlistModel->insert($data);

      return redirect()->to('/playlist');
    }

    public function display($playlistId) {
      // Load your model to interact with the database
      $playlistModel = new PlaylistModel();

      // Assuming you have a method in your model to fetch songs by playlist ID
      $songs = $playlistModel->getSongsByPlaylistId($playlistId);

      // Send the response as JSON
      return $this->response->setJSON($songs);
    }


}
