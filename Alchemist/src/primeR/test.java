package primeR;

import java.awt.Component;
import java.util.Arrays;

import chemaxon.formats.MolFormatException;
import chemaxon.formats.MolImporter;
import chemaxon.marvin.calculations.pKaPlugin;
import chemaxon.marvin.calculations.pKaPluginDisplay;
import chemaxon.marvin.plugin.CalculatorPluginDisplay;
import chemaxon.marvin.plugin.PluginException;
import chemaxon.struc.Molecule;

public class test {

	public static void main(String[] args) {
	try {
		// import a molecule and clean it in 2D
		// Note: clean is not required if the input mol has 2D coordinates
		Molecule mol = MolImporter.importMol("[O-]C(=O)CC[C@H](NC(=O)c1ccc(N2CN3C=4C([O-])=NC(=N)NC4NCC3C2)cc1)C(=O)O");
		mol.clean(2, null);

		// instantiate plugin
		pKaPlugin plugin = new pKaPlugin();

		// set parameters
		// set pH limits and step size for microspecies distribution calculation
		plugin.setpHLower(0);
		plugin.setpHUpper(14);
		plugin.setpHStep(1);
		plugin.setKeepExplicitHydrogens(true);
		//plugin.setModel(pKaPlugin.MODEL_LARGE);
		// set molecule and run the calculation
		mol = molProcess.standardizeMol(mol);
		mol = molProcess.annotatedMolecule(mol, true);
		plugin.setMolecule(mol);
		plugin.standardize(mol);
		plugin.run();
		System.out.println(plugin.getMsCount());
		/*for (int i = 0; i < plugin.getMsCount(); i++) {
			System.out.println(Arrays.toString(plugin.getMsDistribution(i)));
		}*/
		

		// instantiate plugin display, and display the results
		CalculatorPluginDisplay display = new pKaPluginDisplay();
		display.setPlugin(plugin);
		display.store();
		Component component = display.getResultComponent();
		component.setVisible(true);
	}
	catch (MolFormatException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	}
	catch (PluginException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	}

	}

}
