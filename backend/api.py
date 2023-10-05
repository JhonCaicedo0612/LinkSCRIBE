from fastapi import FastAPI, Request
from model_loader import ModelLoader, Framework
from url_scraping import PaginaWebInfo
from pydantic import BaseModel
from textPrepro import texto
import pickle
import pandas as pd
import sys
import numpy as np



class link(BaseModel):
    linkresi: str


app = FastAPI()


@app.on_event("startup")
def load_model():
    """
        This function will run code
        when the application starts up
    """
    print("Loading the  model ...")
    with open("params/le.pk", 'rb') as file:
        app.state.le = pickle.load(file)

    le = app.state.le
    a = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]
    labels = le.inverse_transform(a)
    model = ModelLoader(
        path='models/tf/Linscribe_model',
        labels=labels,
        framework= Framework.tensorflow,
        name='Linscribe_model',
        version=1.0
                        )
    print("Model loaded succesfully!")
    app.state.model = model
    with open("params/CountVectorizer.pk", 'rb') as file:
        app.state.count = pickle.load(file)

    # Cargar el objeto TfidfTransformer
    with open("params/TfidfTransformer.pk", 'rb') as file:
        app.state.Tfidf = pickle.load(file)


@app.get("/")
def read_root():
    return {"message": "Hi from home"}

@app.post("/predit")
async def url_scrap(request: Request):
    request = await request.json()
    url = request['linkresi']
    pagina_info = PaginaWebInfo(url)
    info = pagina_info.obtener_informacion()
    count = app.state.count
    Tfidf = app.state.Tfidf
    model = app.state.model

    if 'Error' in info:
        return {'Error': info['Error']}
    else:
        pre = texto(info['Descripcion'])
        a = pre.prepro()
        prediccion = model.predict(a)
        salida = {"URL":url,"Titulo":info['Titulo'],"Descripcion":info['Descripcion'],"Categoria":prediccion[0],"imagen":info['imagen']}
        return salida



