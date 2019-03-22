<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;

class ManageTmdbApiController extends AbstractController
{
	public function discoverMovies()
	{
		$url = 'https://api.themoviedb.org/3/discover/movie';

		$params = [
			'api_key' => '09cdb2f447b4af00bc50c31d6dcf5f65',
			'sort_by' => 'popularity.desc'
        ];

        $params = '?' . http_build_query($params);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url . $params
        ));

        $results = json_decode(curl_exec($curl));

		$movies = $results->results;

		curl_close($curl);
		
		return $movies;
	}
}