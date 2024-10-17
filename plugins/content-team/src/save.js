/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

import { useBlockProps, InnerBlocks, RichText } from '@wordpress/block-editor';
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
export default function save( { attributes } ) {
	const blockProps = useBlockProps.save();
	return (
		<div { ...blockProps }>
			<section
				className={ `position-relative ${ attributes.section_class }` }
				style={ `padding:50px 0;${ attributes.section_style }` }
				id={ attributes.section_id }
			>
				{ /* <div className="column-wrapper"> */ }
				{ attributes.section_image && (
					<img
						src={ attributes.section_image }
						alt={attributes.section_image_alt}
						className={ `w-100 h-100 position-absolute bg-img ${ attributes.section_image_class }` }
						style={ `top:0;left:0;object-fit:cover;pointer-events:none;${ attributes.section_image_style }` }
					/>
				) }

				<RawHTML>{ attributes.section_block }</RawHTML>

				<div
					className={ attributes.container_class }
					style={ attributes.container_style }
					id={ attributes.container_id }
				>
					<div
						className={ attributes.row_class }
						style={ attributes.row_style }
						id={ attributes.row_id }
					>
						{ attributes.columns.map( ( column, index ) => {
							return (
								<div
									className={ `${ column.col_class }` }
									style={ column.col_style }
								>
									<div
										className={ `${ column.inner_col_class }` }
										style={ `${ column.inner_col_style }` } data-aos={column.data_aos} data-aos-delay={column.data_aos_delay}
									>
										{ column.img && (
											<img
												src={ column.img }
												alt={ column.title }
												style={ column.img_style }
												className={ column.img_class }
											/>
										) }
										<div className='bg-white text-center box-shadow' style={{transform:'translate(0px, -70px)', width:'80%',margin:'auto',borderRadius:'25px',padding:'25px 15px;'}}>
										<h3 className={`h6`} style={{marginTop:'0px'}}>
											<RichText.Content
												value={ column.title }
											/>
										</h3>
										<p style={ { marginBottom: '0px' } }>
											<RichText.Content
												value={ column.content }
											/>
										</p>
										<RawHTML>{ column.code_block }</RawHTML>
										</div>
									</div>
								</div>
							);
						} ) }
					</div>
				</div>

				
			</section>
		</div>
	);
}
