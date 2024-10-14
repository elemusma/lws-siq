/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
	const blockProps = useBlockProps.save();

	// const setOuterHTML = (htmlString) => {
	// 	const tempDiv = document.createElement('div');
	  
	// 	// Append a text node with the HTML string
	// 	tempDiv.appendChild(document.createTextNode(htmlString));
	  
	// 	// Use React.createElement to create a React element based on the outerHTML
	// 	const reactElement = React.createElement('div', { dangerouslySetInnerHTML: { __html: tempDiv.outerHTML } });
	  
	// 	return reactElement;
	//   };

	return (
		<div {...blockProps}>
		<section className={`${attributes.section_class}`} style={`${attributes.section_style}`} id={attributes.section_id}>

		

			<RawHTML>{attributes.section_block}</RawHTML>

			<div className={`${attributes.container_class}`} style={`${attributes.container_style}`} id={attributes.container_id}>
				<div className={attributes.row_class} style={attributes.row_style} id={attributes.row_id}>
					<div className={attributes.col_class} style={attributes.col_style} id={attributes.col_id} data-aos={attributes.col_data_aos} data-aos-delay={attributes.col_data_aos_delay}>

					<InnerBlocks.Content />

					<div className={`${attributes.carousel_class}`} style={`${attributes.carousel_style}`} data-aos={attributes.carousel_data_aos} data-aos-delay={attributes.carousel_data_aos_delay} data-aos-offset={attributes.carousel_data_aos_offset}>
		{ attributes.gallery_images &&
		attributes.gallery_images.map( ( image ) => (
		<a href={ image.url } data-lightbox="slider-carousel" data-title={image.alt}>
			<img
				key={ image.id }
				src={ image.url }
				alt={ image.alt }
				style={`${ attributes.gallery_images_style }`}
				className={`${attributes.gallery_images_class}`}
			/>
			</a>
		) ) }
		</div>

		</div>	
					
				</div>
			</div>
		</section>
		</div>
	);
}
