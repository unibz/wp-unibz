<?php
// Creating the widget 
class unibz_news_widget extends WP_Widget {

	private $APIURLTopics = "https://webservices.scientificnet.org/rest/entries/api/v1/topics";
	private $APIURLNews   = "https://webservices.scientificnet.org/rest/entries/api/v1/news";
	private static $topicList;


	private function loadNews($topics) {
		
		// GET api response
		try {
        	$newsResponse = json_decode(file_get_contents($this->APIURLNews."?topics={$topics}", true));
        	$news = array();
    	}
    	catch(Exception $e) {
    		return null;
    	}

    	// build array
    	if($newsResponse->EntriesList) {
			foreach($newsResponse->EntriesList as $entry) {
				$item = new stdClass();
				$item->Id = $entry->Id;
				if ($entry->Sections) {
					foreach($entry->Sections as $section) {
						if($section->Name == 'TITLE') {
							$item->Title = $section->Content;
						}
					}
				}
				if ($item->Id && $item->Title) {
					array_push($news, $item);
				}
			}
		}

		return $news;
	}


	private function loadTopics() {
		// GET api response
		try {
        	$topicsResponse = json_decode(file_get_contents($this->APIURLTopics, true));
        	$topics = array();
    	}
    	catch(Exception $e) {
    		return null;
    	}

    	// build array
    	if($topicsResponse) {
			foreach($topicsResponse as $entry) {
				$item = new stdClass();
				$item->Id = $entry->Id;
				$item->Name = $entry->Name;
				if ($item->Id && $item->Name) {
					array_push($topics, $item);
				}
			}
		}

		return $topics;
	}


	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'unibz_news_widget', 

			// Widget name will appear in UI
			__('unibz News Feed Widget', 'unibz_news_widget_domain'), 

			// Widget description
			array( 'description' => __( 'Displays unibz news', 'unibz_news_widget_domain' ), ) 
			);
	}


	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		//$title = apply_filters( 'widget_title', $instance['title'] );
		//$topics = apply_filters( 'widget_title', $instance['topics'] );
		$title = $instance['title'];
		$topics = $instance['topics'];
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
        $news = $this->loadNews($topics);
		?>

			<div id="unibz-news-feed-box">
				<?php 
					if($news) {
						echo "<ul>";
						foreach($news as $entry) {
							echo "<li><a href='https://www.unibz.it/en/news/{$entry->Id}' target='_blank'>{$entry->Title}</a></li>";
						}
						echo "</ul>";
					}
					else {
						echo "<div class='alert alert-warning'><small>Due to a connection issue it wasn't possible to load the news feed</small></div>";
					}
				?>
			</div>


		<?php
		echo $args['after_widget'];
	}


	// Widget Backend 
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'unibz_news_widget_domain' );
		}

		if ( isset( $instance[ 'topics' ] ) ) {
			$topics = $instance[ 'topics' ];
		}
		else {
			$topics = __( 'New topics', 'unibz_news_widget_domain' );
		}

		// Widget admin form
        $topicList = $this->loadTopics();
        if($topicList):
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /><br>
				<br>
				<label for="<?php echo $this->get_field_id( 'topics' ); ?>"><?php _e( 'Topics:' ); ?></label> 
				<select name="<?php echo $this->get_field_name( 'topics' ); ?>" id="<?php echo $this->get_field_id( 'topics' ); ?>">
					<?php
						foreach($topicList as $topic) {
							if (esc_attr($topics) == $topic->Id) {
								$selected = 'selected';
							}
							else {
								$selected = '';
							}
							echo "<option value='{$topic->Id}' {$selected}>{$topic->Name}</option>";
						}
					?>
				</select>
			</p>
		<?php
		else:
		?>
			<p class="notice notice-error">
			Sorry, an error occurred while fetching data from the unibz webservice, try again later.
			</p>
		<?php
		endif;
	}
	

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['topics'] = ( ! empty( $new_instance['topics'] ) ) ? strip_tags( $new_instance['topics'] ) : '';
		return $instance;
	}
} // Class unibz_news_widget ends here

function unibz_load_widget() {
	register_widget( 'unibz_news_widget' );
}
add_action( 'widgets_init', 'unibz_load_widget' );
