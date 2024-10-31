import { Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function edit({ attributes }){

    return (
        <Disabled>
			<ServerSideRender
				block="conquer-local/cl-today"
				attributes={ attributes } //the attributes MUST be defined in php as well. See https://github.com/WordPress/gutenberg/tree/trunk/packages/server-side-render
			/>
		</Disabled>
    )
}