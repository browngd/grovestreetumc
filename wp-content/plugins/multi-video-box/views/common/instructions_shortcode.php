<div class="wrap">
	<div class="center"><h2>Using The [mvob] Shortcode</h2></div>
	<p>The [mvob] shortcode requires one of two parameters:
	<ul>
		<li><strong>group</strong> - The ID of the Group that you want to display, such as: <strong>[mvob group=1]</strong></li>
		<li><strong>video</strong> - The ID of the individual Video that you want to display, such as: <strong>[mvob video=1]</strong></li>
	</ul>
	</p>
	<p>If both group and video are passed, group will be used.</p>

	<div class="center"><h2>Additional Parameters</h2></div>
	If you want to custom tailor the output of your Videos, the [mvob] shortcode gives you several options.  You can use any or all of these when you call the [mvob] shortcode.
	<ul>
		<li><strong>tab_side</strong> - Which side of the Video display do you want the tabs on?  Accepts: top (default), left, bottom, and right.  This parameter is ignored if you're only outputting a single Video.</li>
		<li><strong>title_output</strong> - Where do you want the title of the Video displayed?  Accepts: top (default) or bottom</li>
		<li><strong>description_output</strong> - Where do you want the description of the Video displayed?  Accepts: top (default) or bottom</li>
	</ul>

	<h2>Examples</h2>
	<ul>
		<li><strong>[mvob group=1]</strong>:<br/>Outputs the videos for Group #1 with default settings</li>
		<li><strong>[mvob group=12 tab_side="left" title_output="bottom"]</strong>:<br/>Outputs videos for Group #12 with tabs on the left and the title below the video.  Description remains above the video (per default setting).</li>
		<li><strong>[mvob video=2 tab_side="left" description_output="bottom"]</strong>:<br/>Outputs Video #2 with the title above the video (per default setting) and description below the video.  tab_side is ignored because there is only one Video being output.</li>
	</ul>
</div>