import React from 'react'
import { Link } from 'react-router-dom'

export default function Page404() {
  return (
    <div>
        <section className="page_404" style={{ height:"100vh",padding: "40px 0", background:"#fff", fontFamily:"Arvo",display:"flex", alignItems:"center"}}>
            <div className="container">
                <div className="row">	
                    <div className="col-sm-12 ">
                        <div className="col-sm-10 col-sm-offset-1  text-center" style={{ marginLeft:"8.33333333%" }}>
                            <div className="four_zero_four_bg" style={{ backgroundImage:`url("https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif")`, height: "400px", backgroundPosition:"center" }}>
                                <h1 className="text-center" style={{ fontSize:"80px", fontWeight:"700" }}>404</h1>
                            </div>
                        
                            <div className="contant_box_404" style={{ marginTop:"-50px" }}>
                                <h3 className="h2" style={{ fontSize:"26px", fontWeight:"700" }} >
                                    Axtardığınız səhifə mövcud deyil!
                                </h3>
                                
                                
                                <Link to={"/"} className="link_404" style={{ color:"#fff", padding:"10px 20px", background:"#39ac31", margin:"20px 0",display:"inline-block" }}>Ana Səhife</Link>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
  )
}
