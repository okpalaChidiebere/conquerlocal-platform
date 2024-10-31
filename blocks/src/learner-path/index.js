import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";
import edit from './edit';

export const name = cl_blocks.i18n.block_learner_path_name;
export const settings = {
    title: cl_blocks.i18n.block_learner_path_title,
	description: cl_blocks.i18n.block_learner_path_description,
	icon: 'welcome-learn-more',
	category: 'conquer-local', 
	supports: {
		customClassName: false,
	},
	edit,
	save: function( props ) {
		return (
			<div { ...useBlockProps } className="cl-block-container-fw">
				<div className="cl-block-container-inner-container" style={{ padding: '50px 0px'}}>
					<h2 class="cl-pt-color cl-block-title" style={{alignSelf: "center"}}>Grow your business with Vendasta</h2>
					<InnerBlocks.Content/>
				</div>
			</div>
		)
	},
}