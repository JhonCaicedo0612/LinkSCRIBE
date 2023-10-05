import typing
from pathlib import Path
import numpy as np
from enum import Enum

class Framework(Enum):
    tensorflow = 'tensorflow'
    LR = 'LR'
    RF = 'RF'
    SVM = 'SVM'

class ModelLoader:
    def __init__(self,
                 path: typing.Union[str, Path],
                 name: str,
                 version: float = 1.0,
                 framework: Framework = Framework.tensorflow,
                 labels: typing.List[str] = None):
        self.path = path
        self.name = name
        self.version = version
        self.framework = framework
        self.labels = labels

        if self.framework == Framework.tensorflow:
            self.model = self.__load_tensorflow_model()
        elif self.framework == Framework.LR:
            self.model = self.__load__LR_model()
        elif self.framework == Framework.RF:
            self.model = self.__load__RF_model()
        elif self.framework == Framework.SVM:
            self.model = self.__load__SVM_model()
        else:
            raise NotImplementedError(f'Backen {self.framework} is not supported.')


    def __load_tensorflow_model(self):
        """
        Load Tensorflow Model from path
        """
        import tensorflow as tf
        model = tf.keras.models.load_model(self.path)
        return model
           
    
    def __load__LR_model(self):
        """
        Load LR Model from path
        """
        import pickle
        with open(self.path, 'rb') as f:
            return pickle.load(f)

    def __load__RF_model(self):
        """
        Load RF Model from path
        """
        import pickle
        with open(self.path, 'rb') as f:
            return pickle.load(f)
    
    def __load__SVM_model(self):
        """
        Load SVM Model from path
        """
        import pickle
        with open(self.path, 'rb') as f:
            return pickle.load(f)
        
    def predict(self, data: np.ndarray) -> np.ndarray:
        """
        Predict data using model
        """
        predictions =  self.model.predict(data)
        predictions = predictions.tolist()
        
        if self.labels is not None:
            if self.framework == Framework.LR:
                predictions = [self.labels[label_idx] for label_idx in predictions]
            elif self.framework == Framework.tensorflow:
                predictions = [self.labels[np.argmax(prediction)] for prediction in predictions]
            elif self.framework == Framework.SVM:
                predictions = [self.labels[label_idx] for label_idx in predictions]
            elif self.framework == Framework.RF:
                predictions = [self.labels[label_idx] for label_idx in predictions]
        return predictions
      
        