import numpy as np

class PSI:
    def __init__(self, matrix, criteria_type):
        """
        :param matrix: List of List (alternatif × kriteria)
        :param criteria_type: List of str ("benefit" or "cost")
        """
        self.matrix = np.array(matrix, dtype=float)
        self.criteria_type = criteria_type

    def normalize(self):
        norm_matrix = np.zeros_like(self.matrix)
        for j in range(self.matrix.shape[1]):
            col = self.matrix[:, j]
            if self.criteria_type[j] == 'benefit':
                norm_matrix[:, j] = col / col.max()
            else:  # cost
                norm_matrix[:, j] = col.min() / col
        return norm_matrix

    def calculate_weights(self):
        norm_matrix = self.normalize()
        mean_values = norm_matrix.mean(axis=0)
        diffs = np.abs(norm_matrix - mean_values)
        sum_diffs = diffs.sum(axis=0)
        pvv = 1 - sum_diffs / self.matrix.shape[0]
        weights = pvv / np.sum(pvv)
        return weights.tolist()
