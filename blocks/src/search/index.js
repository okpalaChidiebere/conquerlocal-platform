
import edit from './edit';

export const name = cl_blocks.i18n.block_search_name;

export const settings = {
    title: cl_blocks.i18n.block_search_title,
	description: cl_blocks.i18n.block_search_description,
	icon: 'category',
	category: 'conquer-local', 
	attributes: {
		popular_searches: {
			type: 'array',
			items: {
				type: 'string'
			},
			default: cl_blocks.search.popular_searches,
		},
		background_image: {
			type: 'string'
		},
	},
	supports: {
		customClassName: false,
	},
	edit,
	// Render via PHP
	save: function( props ) {
		return null;
	},
}