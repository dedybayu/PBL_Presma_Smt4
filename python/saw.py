import numpy as np
import pandas as pd

class SAW:
    def __init__(self, dataframe, weights, criteria_types, jumlah_anggota):
        self.df = dataframe
        self.weights = np.array(weights)
        self.criteria = np.array(criteria_types)
        self.jumlah_anggota = jumlah_anggota
        self.alternatives = dataframe.iloc[:, 0]
        self.X = dataframe.iloc[:, 1:].values

    def normalize_matrix(self):
        norm_matrix = np.zeros_like(self.X, dtype=float)
        for j in range(self.X.shape[1]):
            if self.criteria[j] == 'benefit':
                norm_matrix[:, j] = self.X[:, j] / np.max(self.X[:, j])
            elif self.criteria[j] == 'cost':
                norm_matrix[:, j] = np.min(self.X[:, j]) / self.X[:, j]
        return norm_matrix

    def run(self):
        norm = self.normalize_matrix()
        scores = norm @ self.weights

        result = pd.DataFrame({
            "mahasiswa_id": self.alternatives,
            "score": scores,
            "rank": (-scores).argsort().argsort() + 1
        }).sort_values("rank").reset_index(drop=True)

        result = result.head(self.jumlah_anggota)
        return result
