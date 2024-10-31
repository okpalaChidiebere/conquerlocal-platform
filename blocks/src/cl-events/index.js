import edit from './edit';
import save from './save'

export const name = cl_blocks.i18n.block_cl_events_name;

export const settings = {
    title: cl_blocks.i18n.block_cl_events_title,
	description: cl_blocks.i18n.block_cl_events_description,
	icon: 'category',
	category: 'conquer-local', 
	supports: {
		customClassName: false,
	},
	attributes: {
		numOfCards: {
			type: "number",
			default: 1,
		},
		eventsPageLink: {
			type: "string",
			default: "",
		}
	},
	edit,
	save,
}