import React, {useEffect, useState} from 'react';
import Form from "react-bootstrap/Form";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Button from "react-bootstrap/Button";
import Footer from '../../components/Footer';
import { useNavigate, useParams } from 'react-router-dom'
import "./file.css";
import apiClient from '../../services/Api';
import Swal from 'sweetalert2';

export default function SiteCategoryUpdate() {
  const { id } = useParams();
  const navigate = useNavigate();
  const token = JSON.parse(localStorage.getItem('authInfo'));

  const [sites, setSites] = useState([]);
  const [selectedSiteId, setSelectedSiteId] = useState();
  const [selectedSiteName, setSelectedSiteName] = useState("");
  const [selectedSites, setSelectedSites] = useState();
  const [place, setPlace] = useState("")
  const [image, setImage] = useState("")
  const [newImage, setNewImage] = useState()
  const [type, setType] = useState("")
  const [status, setStatus] = useState("")
  const [validationError,setValidationError] = useState({})

  useEffect(() => {
    getSitesList();
    getByIdSiteCategory();
  }, []);

  const getByIdSiteCategory = async () => {
    await apiClient.get(`/api/site-category/${id}`,{
        'headers':{
            "Authorization": `Bearer ${token.access_token}`
        }
    }).then(({data})=>{
        if (localStorage.getItem('loggedIn')) {
          const { site_id, site_name, place, image, type, status } = data.message
          setPlace(place);
          setImage(image);
          setStatus(status);
          setType(type)
          setSelectedSiteId(site_id);
          setSelectedSiteName(site_name);
        }
    }).catch(({response:{data}})=>{
        Swal.fire({
        text:data.message,
        icon:"error"
        })
    })
  }

  const getSitesList = async () => {
      await apiClient.get(`/api/sites-without-paginate`,{
        'headers':{
          "Authorization": `Bearer ${token.access_token}`
      }
      }).then((data) => {
          const sites = data.data;
          setSites({sites});
      })
  }
  const updateSiteCategory = async (e) => {
    e.preventDefault();

    const formData = new FormData()
    formData.append('_method', 'PATCH');
    formData.append('site_id', selectedSiteId)
    formData.append('place', place)
    formData.append('type', type)
    formData.append('status', status)
    newImage && formData.append('image', newImage)


    if (localStorage.getItem('loggedIn')) {
        await apiClient.post(`/api/site-category/${id}`, formData,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then(({data})=>{
            Swal.fire({
            icon:"success",
            // text:data.message
            text:"Məlumatlar yeniləndi"
            })
            navigate("/site-categories")
        }).catch(({response})=>{
            if(response.status===422){
            setValidationError(response.data.errors)
            }else{
            Swal.fire({
                text:response.data.message,
                icon:"error"
            })
            }
        })
    }
}


  function showPreview(event){
    if(event.target.files.length > 0){
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("file-ip-1-preview");
        preview.src = src;
        preview.style.display = "block";
        setNewImage(event.target.files[0]);
    }
  }

    return (
      <div>
        <div className="layout-wrapper layout-content-navbar">
            <div className="layout-container">
                <SideBar/>
                <div className="layout-page">
                    <Navbar/>
                    <div className="content-wrapper">
                        <div className="container-xxl flex-grow-1 container-p-y">
                            <h4 className="fw-bold py-3 mb-4"><a href=""><span
                                className="text-muted fw-light">Sayt Kateqoriyalar /</span></a>Yeni Sayt Kateqoriya</h4>
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="card mb-4">
                                        <h5 className="card-header">Yeni Sayt Kateqoriya</h5>
                                        <div className="card-body">
                                            {
                                                Object.keys(validationError).length > 0 && (
                                                    <div className='alert alert-danger'>
                                                        <ul className="mb-0">
                                                            {
                                                                Object.entries(validationError).map(([key, value]) => (
                                                                    <li key={key}>{value}</li>
                                                                ))
                                                            }
                                                        </ul>
                                                    </div>
                                                )
                                            }
                                            <div>
                                                <Form onSubmit={updateSiteCategory}>
                                                    <Row className="my-3">
                                                        <Col>
                                                            <Form.Group controlId="sites">
                                                                <Form.Label>Sayt Adı</Form.Label> 
                                                                <Form.Select value={selectedSiteId} onChange={(e) => setSelectedSiteId(e.target.value)}>
                                                                    <option>Secin</option>
                                                                    {
                                                                        sites?.sites ?
                                                                            sites?.sites?.data.map((site, key) => (
                                                                                <option key={key}
                                                                                        value={site.id}>{site.name}</option>
                                                                            )) : ''
                                                                    }
                                                                </Form.Select>
                                                            </Form.Group>
                                                        </Col>
                                                    </Row>
                                                    <Row className="my-3">
                                                        <Col>
                                                            <Form.Group controlId="ads">
                                                                <Form.Label>Yer</Form.Label>
                                                                <Form.Control type="text" value={place}  onChange={(e) => setPlace(e.target.value)}/>
                                                            </Form.Group>
                                                        </Col>
                                                    </Row>
                                                    <Row className="my-3">
                                                      <Col>
                                                        <Col className="my-3">
                                                            <Form.Group controlId="type">
                                                                <Form.Label>Növ</Form.Label>
                                                                <Form.Select value={type}  onChange={(e) => setType(e.target.value)}>
                                                                    <option>Seçin</option>
                                                                    <option value="web">Web</option>
                                                                    <option value="mobile">Mobile</option>
                                                                </Form.Select>
                                                            </Form.Group>
                                                        </Col>
                                                        <Col>
                                                            <Form.Group controlId="status">
                                                                <Form.Label>Status</Form.Label>
                                                                <Form.Select value={status}  onChange={(e) => setStatus(e.target.value)}>
                                                                    <option>Seçin</option>
                                                                    <option value="active">Active</option>
                                                                    <option value="deactive">Deactive</option>
                                                                </Form.Select>
                                                            </Form.Group>
                                                        </Col>
                                                      </Col>
                                                      <Col>
                                                        <div className="center">
                                                          <div className="form-input">
                                                              <div className="preview">
                                                                  <img id="file-ip-1-preview" src={image} style={{width: "300px", maxHeight:"300px"}} />
                                                              </div>
                                                              <label htmlFor="file-ip-1">Upload Image</label>
                                                              <input type="file" id="file-ip-1"  accept="image/*" onChange={(e) => showPreview(e)} />
                                                          </div>
                                                        </div>
                                                      </Col>
                                                        
                                                    </Row>

                                                    <Button variant="primary" className="mt-2" size="lg"
                                                            block="block" type="submit">
                                                        Redakte et
                                                    </Button>
                                                </Form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Footer/>
                        <div className="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
            <div className="layout-overlay layout-menu-toggle"></div>
        </div>
      </div>
    )
}
