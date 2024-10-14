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
				{/* <div className="column-wrapper"> */}
				{ attributes.section_image && (
					<img
						src={ attributes.section_image }
						alt=""
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


<div className={attributes.col_class} style={attributes.col_style} id={attributes.col_id} data-aos={attributes.col_data_aos} data-aos-delay={attributes.col_data_aos_delay} data-aos-offset={attributes.col_data_aos_delay_offset}>
<InnerBlocks.Content />
</div>



<div className={attributes.testimonial_class} style={attributes.testimonial_style} id={attributes.testimonial_id} data-aos={attributes.testimonial_data_aos} data-aos-delay={attributes.testimonial_data_aos_delay} data-aos-offset={attributes.testimonial_data_aos_delay_offset}>
{
  attributes.testimonials.map((testimonial, index) => {
    return (
        <div className={`position-relative text-center ${testimonial.col_class}`} style={`${testimonial.col_style}`}>
          
          <div className={``} data-aos={testimonial.data_aos} data-aos-delay={testimonial.data_aos_delay}>
            <div className={``}>
				<RawHTML>{testimonial.code_block}</RawHTML>
			{ testimonial.img && (
			<div className={''} style={{display: 'inline-block'}}>
			<img
				src={ testimonial.img }
				alt={ testimonial.alt }
				className={testimonial.img_class}
				style={`border-radius: 50%;height: 100px;width: 100px;object-fit: cover;object-position: top;${testimonial.img_style}`}
			/>
			</div>
)}
			<div className={`position-relative`} style={{paddingLeft:'25px'}}>
			<img src="https://latinowebstudio.com/wp-content/uploads/2024/10/Quotes-Gray.png" className={`position-absolute`} style="object-fit:contain;top:5px;left:0px;width:auto;" width="auto" height="15px" alt="quotes for testimonials" />
            <p style={{ margin: '0px' }} className={`text-left`}><RichText.Content value={testimonial.content} /></p>
			<img src="https://latinowebstudio.com/wp-content/uploads/2024/10/Five-Stars.png" style="width:75px;margin:5px auto;" alt="happy customers" />
			</div>
            </div>
		  <p className={`bold`} style={{ cursor: 'pointer' }}><RichText.Content value={testimonial.title} /></p>
          </div>
        </div>
    );
  })
}
</div> {/* end of testimonial */}


				</div>
				</div>
			</section>
		</div>
	);
}
