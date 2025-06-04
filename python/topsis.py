import numpy as np
import pandas as pd

class Topsis:
    def __init__(self, dataframe, weights, criteria_types):
        self.df = dataframe
        self.weights = np.array(weights)
        self.criteria = np.array(criteria_types)
        self.alternatives = dataframe.iloc[:, 0]
        self.X = dataframe.iloc[:, 1:].values

    def normalize_matrix(self):
        return self.X / np.sqrt((self.X ** 2).sum(axis=0))

    def weighted_normalized_matrix(self, norm_matrix):
        
        return norm_matrix * self.weights

    def ideal_solutions(self, V):
        ideal_pos = np.where(self.criteria == 'benefit', np.max(V, axis=0), np.min(V, axis=0))
        ideal_neg = np.where(self.criteria == 'benefit', np.min(V, axis=0), np.max(V, axis=0))
        return ideal_pos, ideal_neg

    def distance_to_ideal(self, V, ideal):
        return np.sqrt(((V - ideal) ** 2).sum(axis=1))

    def closeness_coefficient(self, D_plus, D_minus):
        return D_minus / (D_plus + D_minus)

    def run(self):
        norm = self.normalize_matrix()
        V = self.weighted_normalized_matrix(norm)
        A_plus, A_minus = self.ideal_solutions(V)
        D_plus = self.distance_to_ideal(V, A_plus)
        D_minus = self.distance_to_ideal(V, A_minus)
        C = self.closeness_coefficient(D_plus, D_minus)

        # result = pd.DataFrame({
        #     "Mahasiswa": self.alternatives,
        #     "C": C,
        #     "Ranking": C.argsort()[::-1] + 1
        # }).sort_values("C", ascending=False).reset_index(drop=True)

        # Hitung ranking berdasarkan nilai C tertinggi
        # ranking = (-C).argsort().argsort() + 1

        # Buat DataFrame hasil
        result = pd.DataFrame({
            "Mahasiswa": self.alternatives,
            "C": C,
            "Ranking": (-C).argsort().argsort() + 1
        }).sort_values("Ranking").reset_index(drop=True)

        return result
