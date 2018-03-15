<?php
/*
 * lastfmを扱うクラス
 */
require_once LFMUTILS_DIR_PATH . 'inc/utils/class-cache-utils.php';	// キャッシュ使用

if ( ! class_exists( 'LastFmUtils' ) ) {
class LastFmUtils {

	static private $instance = null;	// インスタンス

	private $apiKey = null;		// api key
	private $username = null;	// username
	private $cache = null;

	/*
	 * コンストラクタ
	 */
	public function __construct( $username, $api_key, $cache_dir = null, $cache_expire = null ) {
		if ( empty( $username ) || empty( $api_key ) ) {
			throw new Exception( 'LastFmUtils construction failed.(username:' . $username . ',apikey:' . $api_key . ')' );
		}
		try {
			$this->username = $username;
			$this->apiKey = $api_key;
			$this->cache = CacheUtils::getInstance( $cache_dir, $cache_expire );
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/*
	 * インスタンスを取得
	 */
	public static function getInstance( $username, $api_key, $cache_dir = null, $cache_expire = null ) {
		if ( empty( $instance ) ) {
			try {
				$instance = new LastfmUtils( $username, $api_key, $cache_dir, $cache_expire );
			} catch ( Exception $e ) {
				throw $e;
			}
		}
		return $instance;
	}

	/*
	 * 最近のトラックを取得
	 */
	public function getRecentTracks( $limit = 3 ) {
		// JSON取得
		$url = 'http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks'
			. '&user=' . $this->username
			. '&api_key=' . $this->apiKey
			. '&limit=' . $limit
			. '&format=json';
		$json = $this->cache->getContents( $url, 'user.getrecenttracks-'.$limit.'.json' );
		if ( $json == false ) {
			throw new Exception( 'getContents failed.' );
		}
		$data = json_decode( $json, true );

		try {
			$tracks = array();
			foreach( $data['recenttracks']['track'] as $track ){
				$trackinfo = $this->getTrackInfo( $track['artist']['#text'], $track['name'] );
				$tracks[] = $trackinfo;
			}
			return $tracks;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/*
	 * トップトラックを取得
	 */
	public function getTopTracks( $period = 'overall', $limit = 3 ) {
		// JSON取得
		$url = 'http://ws.audioscrobbler.com/2.0/?method=user.gettoptracks'
			. '&user=' . $this->username
			. '&api_key=' . $this->apiKey
			. '&period=' . $period
			. '&limit=' . $limit
			. '&format=json';
		$json = $this->cache->getContents( $url, 'user.gettoptracks-'.$period.'-'.$limit.'.json' );
		if ( $json == false ) {
			throw new Exception( 'getContents failed.' );
		}
		$data = json_decode( $json, true );

		try {
			$tracks = array();
			foreach( $data['toptracks']['track'] as $track ){
				$trackinfo = $this->getTrackInfo( $track['artist']['name'], $track['name'] );
				$tracks[] = $trackinfo;
			}
			return $tracks;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/*
	 * トップアルバムを取得
	 */
	public function getTopAlbums( $period = 'overall', $limit = 3 ) {
		// JSON取得
		$url = 'http://ws.audioscrobbler.com/2.0/?method=user.gettopalbums'
			. '&user=' . $this->username
			. '&api_key=' . $this->apiKey
			. '&period=' . $period
			. '&limit=' . $limit
			. '&format=json';
		$json = $this->cache->getContents( $url, 'user.gettopalbums-'.$period.'-'.$limit.'.json' );
		if ( $json == false ) {
			throw new Exception( 'getContents failed.' );
		}
		$data = json_decode( $json, true );

		try {
			$albums = array();
			foreach( $data['topalbums']['album'] as $album ){
				// $albuminfo = get_albuminfo($album['artist']['name'], $album['name']);
				$albuminfo = array();
				$albuminfo['url'] = $album['url'];
				$albuminfo['name'] = $album['name'];
				$albuminfo['artist_name'] = $album['artist']['name'];
				if ( ! empty( $album['image'][1]['#text'] ) ) {
					$albuminfo['image'] = $album['image'][1]['#text'];
				} else {
					$albuminfo['image'] = null;
				}
				$albums[] = $albuminfo;
			}
			return $albums;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/*
	 * トップアーティストを取得
	 */
	public function getTopArtists( $period = 'overall', $limit = 3 ) {
		// JSON取得
		$url = 'http://ws.audioscrobbler.com/2.0/?method=user.gettopartists'
			. '&user=' . $this->username
			. '&api_key=' . $this->apiKey
			. '&period=' . $period
			. '&limit=' . $limit
			. '&format=json';
		$json = $this->cache->getContents( $url, 'user.gettopartists-'.$period.'-'.$limit.'.json' );
		if ( $json == false ) {
			throw new Exception( 'getContents failed.' );
		}
		$data = json_decode( $json, true );

		try {
			$artists = array();
			foreach( $data['topartists']['artist'] as $artist ){
				$artistinfo = array();
				$artistinfo['url'] = $artist['url'];
				$artistinfo['name'] = $artist['name'];
				if ( ! empty( $artist['image'][1]['#text'] ) ) {
					$artistinfo['image'] = $artist['image'][1]['#text'];
				} else {
					$artistinfo['image'] = null;
				}
				$artists[] = $artistinfo;
			}
			return $artists;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/*
	 * トラック情報を取得
	 */
	public function getTrackInfo( $artist, $track ) {
		// JSON取得
		$url = 'http://ws.audioscrobbler.com/2.0/?method=track.getInfo'
			. '&api_key=' . $this->apiKey
			. '&artist=' . rawurlencode( $artist )
			. '&track=' . rawurlencode( $track )
			. '&format=json';
		$json = $this->cache->getContents( $url, 'track.getInfo_'.rawurlencode( $artist ).'_'.rawurlencode( $track ).'.json' );
		if ( $json == false ) {
			throw new Exception( 'getContents failed.' );
		}
		$data = json_decode( $json, true );

		try {
			$trackinfo = array();
			$trackinfo['url'] = $data['track']['url'];
			$trackinfo['name'] = $track;
			$trackinfo['artist_name'] = $artist;
			$trackinfo['album_name'] = $data['track']['album']['title'];
			if ( ! empty( $data['track']['album']['image'][1]['#text'] ) ) {
				$trackinfo['image'] = $data['track']['album']['image'][1]['#text'];
			} else {
				$trackinfo['image'] = null;
			}
			return $trackinfo;
		} catch ( Exception $e ) {
			return $e;
		}
	}

	/*
	 * アルバム情報を取得
	 */
	public function getAlbumInfo( $artist, $album ) {
		// JSON取得
		$url = 'http://ws.audioscrobbler.com/2.0/?method=album.getinfo'
			. '&api_key=' . $this->apiKey
			. '&artist=' . rawurlencode( $artist )
			. '&album=' . rawurlencode( $album )
			. '&format=json';
		$json = $this->cache->getContents( $url, 'album.getInfo_'.rawurlencode( $artist ).'_'.rawurlencode( $album ).'.json' );
		if ( $json == false ) {
			throw new Exception( 'getContents failed.' );
		}
		$data = json_decode( $json, true );

		try {
			$albuminfo = array();
			$albuminfo['url'] = $data['album']['url'];
			$albuminfo['name'] = $album;
			$albuminfo['artist_name'] = $artist;
			if ( ! empty( $data['album']['image'][1]['#text'] ) ) {
				$albuminfo['image'] = $data['album']['image'][1]['#text'];
			} else {
				$albuminfo['image'] = null;
			}
			return $albuminfo;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

}
}

?>
