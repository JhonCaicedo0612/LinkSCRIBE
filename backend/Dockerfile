FROM python:3.11 as builder
WORKDIR /tmp
RUN pip install poetry
COPY ./pyproject.toml  /tmp/
RUN poetry export -f requirements.txt --output requirements.txt --without-hashes

FROM python:3.11
RUN apt-get update -y && apt-get install build-essential -y

WORKDIR /app
COPY --from=builder /tmp/requirements.txt requirements.txt
RUN pip install --no-cache-dir --upgrade -r requirements.txt
RUN pip install tensorflow
RUN pip install beautifulsoup4
RUN pip install lxml
COPY . .

RUN pwd && ls -la 

CMD ["uvicorn", "--host", "0.0.0.0", "--reload", "--reload-dir", ".", "api:app", "--port", "8080"]