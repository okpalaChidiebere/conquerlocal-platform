import edit from './edit';
import save from './save';

export const name = cl_blocks.i18n.success_stories_name;

export const settings = {
    title: cl_blocks.i18n.success_stories_title,
	description: cl_blocks.i18n.success_stories_description,
	icon: 'awards',
	category: 'conquer-local', 
	supports: {
		customClassName: false,
	},
	attributes:{
		imageUrl: {
			type: "string",
			default: "",
		},
		linkUrl: {
			type: "string",
			default: "",
		},
        name: {
			type: "string",
			default: "",
		},
		personTitle:{
			type: "string",
			default: "",
		},
        quote: {
			type: "string",
			default: "",
		},
        impactBlob: {
			type: "string",
			default: "",
		},
	},
	edit,
	save,
}