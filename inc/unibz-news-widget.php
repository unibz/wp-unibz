<?php
// Creating the widget 
class unibz_news_widget extends WP_Widget {

	private $APIURLTopics = "https://webservices.scientificnet.org/rest/entries/api/v1/topics";
	private $APIURLNews   = "https://webservices.scientificnet.org/rest/entries/api/v1/news";
	private static $topicList;


	private function loadNews($topics, $limit = 5) {
		
		// GET api response
		try {
        	$newsResponse = json_decode(file_get_contents($this->APIURLNews."?cache=false&topics={$topics}&limit={$limit}", true));
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
				$item->Date = strtotime($entry->ValidFrom);
				if ($entry->Sections) {
					foreach($entry->Sections as $section) {
						if($section->Name == 'TITLE') {
							$item->Title = $section->Content;
						}
						if($section->Name == 'TEASER') {
							$item->Teaser = $section->Content;
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
        	$topicsResponse = json_decode(file_get_contents($this->APIURLTopics.'?cache=false&topictype=news&lists=unibznews', true));
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
		$title = $instance['title'];
		$topics = $instance['topics'];
		$show_teaser = $instance['show_teaser'];
		$show_date = $instance['show_date'];
		$limit = $instance['limit'] ? $instance['limit'] : 5;
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
        $news = $this->loadNews($topics, $limit);
		?>

			<div id="unibz-news-feed-box">
				<?php 
					if($news) {
						$date = null;
						echo "<ul>";
						foreach($news as $entry) {
							
							if($show_date && $date != $entry->Date) {
								$date = $entry->Date;
								$timestamp = date('c', $date);
								$pretty_date = date('d M Y', $date);
								echo "<li class='date-item'><time class='entry-date published' datetime='{$timestamp}'>{$pretty_date}</time></li>";
							}

							echo "<li>";
							echo "<a href='https://www.unibz.it/en/news/{$entry->Id}' target='_blank'>{$entry->Title}</a>";
							if($show_teaser === 'on') {
								echo "<br><p>{$entry->Teaser}</p>";
							}
							echo "</li>";
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

		if ( isset( $instance[ 'limit' ] ) ) {
			$limit = $instance[ 'limit' ];
		}
		else {
			$limit = __( '5', 'unibz_news_widget_domain' );
		}

		if ( isset( $instance[ 'show_teaser' ] ) ) {
			$show_teaser = $instance[ 'show_teaser' ];
		}
		else {
			$show_teaser = __( 'off', 'unibz_news_widget_domain' );
		}

		if ( isset( $instance[ 'show_date' ] ) ) {
			$show_date = $instance[ 'show_date' ];
		}
		else {
			$show_date = __( 'off', 'unibz_news_widget_domain' );
		}

		// Widget admin form
        $topicList = $this->loadTopics();
        if($topicList):
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /><br>
				<br>
				<label for="<?php echo $this->get_field_id( 'topics' ); ?>"><?php _e( 'Feed:' ); ?></label> 
				<select class="widefat" name="<?php echo $this->get_field_name( 'topics' ); ?>" id="<?php echo $this->get_field_id( 'topics' ); ?>">
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
				</select><br>
				<br>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'How many items would you like to display?' ); ?></label> 
				<input style="width:80px" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>" min="1" max="25" /><br>
				<br>
				<input id="<?php echo $this->get_field_id( 'show_teaser' ); ?>" name="<?php echo $this->get_field_name( 'show_teaser' ); ?>" type="checkbox" <?php if($show_teaser==='on') echo "checked"; ?> />
				<label for="<?php echo $this->get_field_id( 'show_teaser' ); ?>"><?php _e( 'Display item content?' ); ?></label><br>
				<br>
				<input id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" <?php if($show_date==='on') echo "checked"; ?> />
				<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display item date?' ); ?></label>

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
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? strip_tags( $new_instance['limit'] ) : '5';
		$instance['show_teaser'] = ( ! empty( $new_instance['show_teaser'] ) ) ? strip_tags( $new_instance['show_teaser'] ) : 'off';
		$instance['show_date'] = ( ! empty( $new_instance['show_date'] ) ) ? strip_tags( $new_instance['show_date'] ) : 'off';
		return $instance;
	}
} // Class unibz_news_widget ends here

function unibz_load_widget() {
	register_widget( 'unibz_news_widget' );
}
add_action( 'widgets_init', 'unibz_load_widget' );
